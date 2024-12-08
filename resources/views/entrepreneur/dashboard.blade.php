@extends('entrepreneur.layout')

@section('title', 'Dashboard - Auxiliare')

@section('content')
<div class="half">
  <div class="container4">
    <section class="card4">
      <header class="card-header">
        <h2>Get Started with Your Idea</h2>
        <hr>
      </header>
      <div class="card-body">
        <p>Every great success story begins with an idea, but it’s the courage to act that turns dreams into reality. Auxiliare is here to empower you with the tools, community, and opportunities to bring your vision to life. Whether you’re creating something new or refining an existing idea, today is the day to take that first bold step. Your journey to innovation and impact starts now—let’s shape the future together.</p>
        <a href="{{ route('entrepreneur.create_project') }}" class="cta-button">Create New Project</a>
        <a href="#edit-project" class="cta-button">Edit Existing Project</a>
      </div>
    </section>
  </div>

  <div class="container4">
    <section class="card5">
      <header class="card-header">
        <h2>Auxiliare</h2>
        <hr>
      </header>
      <div class="card-body">
        <p>
          <hr>Auxiliare is dedicated to creating a digital platform that blends entrepreneurship with investment and research, fostering a sustainable environment in which startups can attain networking and funding opportunities. The platform streamlines the path for entrepreneurs from inception to market success. Auxiliare ensures that the entrepreneurial spirit is nurtured with the right tools, enabling collaboration and investment, which continue to drive vibrant community ideas towards global success.
        </p>
        <div class="lower"></div>
      </div>
    </section>
  </div>
</div>
@endsection