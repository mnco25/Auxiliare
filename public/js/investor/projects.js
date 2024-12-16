document.addEventListener("DOMContentLoaded", function () {
    const filterButtons = document.querySelectorAll(".category-filter");
    const projectsGrid = document.querySelector(".projects-grid");
    const statsContent = document.querySelector(".stats-category");

    filterButtons.forEach((button) => {
        button.addEventListener("click", async function () {
            // Remove active class from all buttons
            filterButtons.forEach((btn) => btn.classList.remove("active"));
            // Add active class to clicked button
            this.classList.add("active");

            const category = this.dataset.category;

            try {
                // Show loading state
                projectsGrid.style.opacity = "0.5";
                projectsGrid.style.pointerEvents = "none";

                // Fetch filtered projects
                const response = await fetch(
                    `/investor/filter-projects?category=${category}`,
                    {
                        headers: {
                            "X-Requested-With": "XMLHttpRequest",
                        },
                    }
                );

                const data = await response.json();

                // Animate out old content
                projectsGrid.style.opacity = "0";

                // Update content
                setTimeout(() => {
                    projectsGrid.innerHTML = data.html;

                    // Update stats
                    document.querySelector(
                        ".info-box-content span:last-child"
                    ).textContent = data.totalProjects;
                    document.querySelector(
                        ".info-box:last-child .info-box-content span:last-child"
                    ).textContent =
                        "₱" + Number(data.totalFundingNeeded).toLocaleString();

                    // Animate in new content
                    projectsGrid.style.opacity = "1";
                    projectsGrid.style.pointerEvents = "auto";
                }, 300);
            } catch (error) {
                console.error("Error:", error);
                projectsGrid.style.opacity = "1";
                projectsGrid.style.pointerEvents = "auto";
            }
        });
    });

    // Investment handling
    let currentProjectId = null;
    const modal = $("#investmentModal");

    // Update modal content when showing
    modal.on("show.bs.modal", function (event) {
        const button = $(event.relatedTarget);
        currentProjectId = button.data("project-id");
        const projectTitle = button.data("project-title");
        const minInvestment = button.data("min-investment");
        const maxInvestment = button.data("max-investment");

        $("#projectTitle").text(projectTitle);
        $("#minInvestment").text(numberFormat(minInvestment));
        $("#maxInvestment").text(numberFormat(maxInvestment));

        const amountInput = $("#investmentAmount");
        amountInput.attr("min", minInvestment);
        amountInput.attr("max", maxInvestment);
    });

    // Handle investment submission
    $("#confirmInvestment").click(async function () {
        const amount = $("#investmentAmount").val();

        try {
            const response = await fetch(
                `/investor/projects/${currentProjectId}/invest`,
                {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector(
                            'meta[name="csrf-token"]'
                        ).content,
                    },
                    body: JSON.stringify({ amount: parseFloat(amount) }),
                }
            );

            const result = await response.json();

            if (result.success) {
                modal.modal("hide");
                // Show success message and reload the page
                Swal.fire({
                    title: "Success!",
                    text: "Your investment has been processed successfully",
                    icon: "success",
                    confirmButtonText: "OK",
                }).then(() => {
                    window.location.reload();
                });
            } else {
                throw new Error(result.message || "Investment failed");
            }
        } catch (error) {
            Swal.fire({
                title: "Error",
                text:
                    error.message ||
                    "An error occurred while processing your investment",
                icon: "error",
                confirmButtonText: "OK",
            });
        }
    });

    function numberFormat(number) {
        return new Intl.NumberFormat("en-PH", {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2,
        }).format(number);
    }
});
