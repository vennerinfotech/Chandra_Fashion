@extends('layouts.app')

@section('title', 'About Us')

@section('content')

    <section class="breadcrumb-wrapper top-section-padding">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">About Us</li>
            </ol>
            <h2 class="breadcrumb-title">About Us</h2>
        </nav>
    </section>

    <section class="about-section section-padding">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="position-relative about-img">
                        <img src="/images/hero-banner.png" alt="Model" class="img-fluid w-100">
                        <div class="experience-badge">
                            35 <br> <small>Years<br>Experience</small>
                        </div>
                        <div class="testimonial-box">
                            <em>"Exceptional quality and reliability. Chandra Fashion has been our manufacturing partner for
                                5 years."</em>
                            <br>
                            <small>- Roshni</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about-content">
                        <h6 class="sub-title">About Company</h6>
                        <h2 class="title">Well-Coordinated Teamwork Speaks About Us</h2>
                        <p class="">Established in year 1985, we, Chandra Fashion is one of the leading Manufacturers
                            of Knitted Fabrics, Polyester Lycra Fabrics, Lycra Fabrics, Sublimation Fabrics, Dry-fit Fabric,
                            Pique Fabrics and many more. Our claim to success is hallmarked by the offered quality products
                            that gained us huge recognizance. We are working towards development through a determined team
                            of people to meet customers' most stringent requirements.</p>
                        <p class="">Under the leadership of our mentor, Mr. Rajesh Khiyaram Balani, we have attained a
                            commendable position in this domain.
                            Our well-reputed company, Chandra Fashion, was founded in 1985 in Surat, Gujarat, India. We
                            manufacture and supply various kinds of fabrics, including Classic Polo Fabric, US Polo Green
                            Fabric, Chex Polo Fabric, Fanta Lycra Fabric, Karara Fabric, and more.</p>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <section class="why-about-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="why-about-content">
                        <h2 class="title">Why Choose Us?</h2>
                        <p class="">For now, more than 35 Years we have been consistent in the delivery of quality and
                            quantity products like 2-way Semi Zurick Fabric, 4-way Zurich Fabric, Twill Spandex Fabric, Dry
                            Fit Fabric & Rice Knit Tube Fabric, and more. Our products find use in various sectors, and due
                            to their impeccable quality, they are highly appreciated by clients worldwide..</p>
                        <p class="">We follow the set standards of quality parameters and pass each item through a
                            series of quality assurance tests to ensure the same.
                            Apart from that, listed below are a few other reasons why our clients choose us:</p>
                        <div class="listing">
                            <ul>
                                <li><i class="fa-solid fa-circle-check"></i>Market-leading prices</li>
                                <li><i class="fa-solid fa-circle-check"></i>Strong vendor base</li>
                                <li><i class="fa-solid fa-circle-check"></i>A varied product range</li>
                                <li><i class="fa-solid fa-circle-check"></i>Effective after-sale services</li>
                            </ul>
                        </div>
                    </div>

                </div>
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="position-relative about-img">
                        <img src="/images/product2.jpg" alt="Model" class="img-fluid w-100">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="states-section section-padding">
        <div class="container">
            <div class="stats-container">
                <div class="stat-box">
                    <div class="stat-icon"><i class="fas fa-user"></i></div>
                    <div class="d-flex justify-content-center">
                        <div class="stat-number" data-count="15">0</div><span>k</span>
                    </div>
                    <div class="stat-label">Happy Customers</div>
                </div>
                <div class="stat-box">
                    <div class="stat-icon"><i class="fa-solid fa-users"></i></div>
                    <div class="d-flex justify-content-center">
                        <div class="stat-number" data-count="15">0</div><span>+</span>
                    </div>

                    <div class="stat-label">Team Members</div>
                </div>
                <div class="stat-box">
                    <div class="stat-icon"><i class="fa-solid fa-medal"></i></div>
                    <div class="d-flex justify-content-center">
                        <div class="stat-number" data-count="50">0</div><span>+</span>
                    </div>
                    <div class="stat-label">Total Awards</div>
                </div>
                <div class="stat-box">
                    <div class="stat-icon"><i class="fas fa-shopping-cart"></i></div>
                    <div class="d-flex justify-content-center">
                        <div class="stat-number" data-count="500">0</div><span>+</span>
                    </div>
                    <div class="stat-label">Total Products</div>
                </div>
            </div>
        </div>
    </section>

    <section class="team-leader-section section-padding">
        <div class="container">
            <div class="row">
                <h2 class="section-title">Our Team</h2>
                <p class="section-sub-title">Visionary leaders driving our success</p>
            </div>
            <div class="row">
                <div class="col-md-6 col-lg-3">
                    <div class="team-leader-card">
                        <img src="/images/team.png" alt="Leader 1" class="leader-photo">
                        <h2 class="name">Akshar Patel</h2>
                        <p class="designation">CEO</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="team-leader-card">
                        <img src="/images/team2.png" alt="Leader 1" class="leader-photo">
                        <h2 class="name">Roshni Patel</h2>
                        <p class="designation">CTO</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="team-leader-card">
                        <img src="/images/team.png" alt="Leader 1" class="leader-photo">
                        <h2 class="name">Akshar Patel</h2>
                        <p class="designation">Manager</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="team-leader-card">
                        <img src="/images/team2.png" alt="Leader 1" class="leader-photo">
                        <h2 class="name">Roshni Patel</h2>
                        <p class="designation">CTO</p>
                    </div>
                </div>
            </div>
    </section>

    <script>
        // Function to animate counting
        function countUp(element) {
            const targetNumber = parseInt(element.getAttribute('data-count'), 10);
            let currentNumber = 0;

            const interval = setInterval(() => {
                if (currentNumber < targetNumber) {
                    currentNumber += Math.ceil(targetNumber / 100);
                    element.textContent = currentNumber;
                } else {
                    clearInterval(interval);
                    element.textContent = targetNumber; // Ensure the final number is set.
                }
            }, 10); // Adjust the speed by changing the interval time
        }

        // Intersection Observer to detect when the section is in view
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const statNumbers = entry.target.querySelectorAll('.stat-number');
                    statNumbers.forEach(statNumber => countUp(statNumber));
                    observer.unobserve(entry.target); // Stop observing after animation
                }
            });
        }, {
            threshold: 0.5
        }); // Adjust the threshold as needed (0.5 means half of the section is in view)

        const section = document.querySelector('.states-section');
        observer.observe(section);
    </script>

@endsection
