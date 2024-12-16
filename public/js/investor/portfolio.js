// Add animated counter effect
function animateValue(element, start, end, duration) {
    let startTimestamp = null;
    const step = (timestamp) => {
        if (!startTimestamp) startTimestamp = timestamp;
        const progress = Math.min((timestamp - startTimestamp) / duration, 1);
        const current = Math.floor(progress * (end - start) + start);
        
        if (element.classList.contains('percentage')) {
            element.textContent = current.toFixed(1) + '%';
        } else if (element.classList.contains('stat-value') && !element.classList.contains('currency')) {
            element.textContent = current;
        } else {
            element.textContent = '₱' + current.toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }
        
        if (progress < 1) {
            window.requestAnimationFrame(step);
        }
    };
    window.requestAnimationFrame(step);
}

// Animate all stat values on page load
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.stat-value').forEach(stat => {
        const value = parseFloat(stat.dataset.value);
        if (!isNaN(value)) {
            animateValue(stat, 0, value, 2000);
        }
    });
    
    // Existing status filter code
    document.getElementById('statusFilter').addEventListener('change', function() {
        const status = this.value;
        const items = document.querySelectorAll('.investment-item');
        
        items.forEach(item => {
            if (!status || item.querySelector('.status-badge').textContent.trim() === status) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    });
});
