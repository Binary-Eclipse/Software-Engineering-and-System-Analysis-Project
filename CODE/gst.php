<?php
// gst.php - Combines session check and HTML content

session_start();
// Include config.php for database connection. 
// Assuming config.php defines a connection variable like $conn.
include_once "config.php";

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // If not logged in, redirect to the new login page name
    header("Location: login.php"); 
    exit();
}
// If logged in, the script continues and outputs the HTML content below.
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Save Paws Home - Rescue, Heal, Protect, Love</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css" integrity="sha512-DxV+EoADOkOygM4IR9yXP8Sb2qwgidEmeqAEmDKIOfPRQZOWbXCzLC6vjbZyy0vPisbH2SyW27+ddLVCN+OMzQ==" crossorigin="anonymous" referrerpolicy="no-referrer"
    />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        
        .faq-item .faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-in-out;
        }
        
        .faq-item.open .faq-answer {
            max-height: 200px;
            /* Adjust max-height for content length */
        }
        
        .faq-item.open .icon-plus {
            transform: rotate(45deg);
        }
        
        /* MAIN CAROUSEL STYLES */
        .gallery-section {
            position: relative;
            background: #fdfdff;
            padding-bottom: 4rem;
            overflow: hidden;
        }
        
        .swiper {
            width: 100%;
            padding-top: 50px;
            padding-bottom: 80px;
        }
        
        .swiper-slide {
            background-position: center;
            background-size: cover;
            width: 280px;
            height: 380px;
            border-radius: 1rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            transition: transform 0.4s ease-in-out, box-shadow 0.4s ease-in-out;
            position: relative;
        }
        
        @media (min-width: 768px) {
            .swiper-slide {
                width: 320px;
                height: 420px;
            }
        }
        
        .swiper-slide-active {
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            transform: scale(1.05);
        }
        
        .swiper-slide img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 1rem;
        }
        
        .swiper-slide .play-icon {
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
            pointer-events: none;
            border-radius: 1rem;
        }
        
        .swiper-slide-active .play-icon,
        .swiper-slide:hover .play-icon {
            opacity: 1;
        }
        
        .swiper-button-prev,
        .swiper-button-next {
            position: absolute;
            bottom: 20px;
            top: auto;
            width: 44px;
            height: 44px;
            background-color: white;
            border-radius: 50%;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            color: #555;
            z-index: 10;
        }
        
        .swiper-button-prev:hover,
        .swiper-button-next:hover {
            color: #4f46e5;
        }
        
        .swiper-button-prev:after,
        .swiper-button-next:after {
            font-size: 1rem;
            font-weight: 700;
        }
        
        .swiper-button-prev {
            left: 50%;
            transform: translateX(-120%);
        }
        
        .swiper-button-next {
            left: 50%;
            transform: translateX(20%);
        }
        
        /* FILTER BUTTON STYLES (for main page and overlays) */
        .category-filter-btn,
        .blog-filter-btn {
            background-color: white;
            color: #555;
            font-weight: 500;
            padding: 0.5rem 1.25rem;
            border-radius: 9999px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            transition: all 0.2s ease;
            border: 1px solid #ddd;
        }
        
        .category-filter-btn.active,
        .blog-filter-btn.active {
            background-color: #4f46e5;
            color: white;
            border-color: #4f46e5;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.2);
        }
    </style>
</head>

<body class="bg-gray-50">

    <nav class="flex flex-wrap justify-between items-center   py-4 bg-white shadow-lg">
                    <h1 class="font-semibold  md:text-xl text-lg  text-sky-500 my-auto ml-5"><i class="fa-solid fa-paw text-amber-950"></i>SavePaws</h1>
        <ul class="hidden lg:flex mx-auto justify-around flex-wrap">
            <li><a href="gst.php" class="text-sm lg:text-sm font-bold text-black hover:text-indigo-600 lg:p-5 transform transition-transform hover:scale-120">Home</a></li>
            <li><a href="marketplace.php" class="text-sm lg:text-sm font-bold text-black hover:text-indigo-600 lg:p-5 transform transition-transform hover:scale-120">Shop</a></li>
            <li><a href="clinic.php" class="text-sm lg:text-sm font-bold text-black hover:text-indigo-600 lg:p-5 transform transition-transform hover:scale-120">Clinics</a></li>
            <li><a href="rescue.php" class="text-sm lg:text-sm font-bold text-black hover:text-indigo-600 lg:p-5 transform transition-transform hover:scale-120">Rescue</a></li>
            <li><a href="blog.php" class="text-sm lg:text-sm font-bold text-black hover:text-indigo-600 lg:p-5 transform transition-transform hover:scale-120">Blog</a></li>
            <li><a href="adopt.php" class="text-sm lg:text-sm font-bold text-black hover:text-indigo-600 lg:p-5 transform transition-transform hover:scale-120">Adopt</a></li>
            <li><a href="donation.php" class="text-sm lg:text-sm font-bold text-black hover:text-indigo-600 lg:p-5 transform transition-transform hover:scale-120">Donate</a></li>
        </ul>


        <div class=" hidden lg:flex items-center space-x-5 mr-5">

                     <a href="https://t.me/savepaws_petcommunity" class="flex items-center px-2 py-1 rounded-xl bg-blue-300 hover:bg-blue-400 transition text-sm lg:text-base">
                <i class="fa-brands fa-twitch md:text-xs " style="color: #9146FF;"></i>
                <span>Join Community</span>
            </a>
        
            <div class="flex justify-center items-center space-x-2">
                <a href="profile.php?page=dashboard" class="text-xl text-black hover:text-indigo-600 transition-colors" aria-label="User Profile">
                    <i class="fa-solid fa-user-circle"></i> 
                </a>
                <a href="login.php" class="text-sm lg:text-sm font-bold text-black hover:text-indigo-600">Logout</a>
            </div>
            </div>

       <button id="menu-btn" class="lg:hidden text-xl text-black mr-5">
      <i class="fa-solid fa-bars"></i>
    </button>
    </nav>

    <ul id="mobile-menu" class="hidden flex-col space-y-4 border-t-4 border-gray-500 bg-white shadow-md p-6 lg:hidden">

          <div class="  flex items-center justify-evenly space-x-2 lg:space-x-5 bg-gray-200 rounded-2xl py-2">
                      <a href="profile.php?page=dashboard" class="rounded-full bg-slate-300 shadow-md w-14 h-14 flex items-center justify-center text-2xl text-black hover:text-indigo-600" aria-label="User Profile">
                        <i class="fa-solid fa-user-circle"></i>
                     </a>


                     <a href="#" class="flex items-center px-2 py-3 rounded-xl bg-blue-300 hover:bg-blue-400 transition text-sm lg:text-base">
                <i class="fa-brands fa-twitch text-sm lg:text-sm mr-2" style="color: #9146FF;"></i>
                <span>Join Community</span>
            </a>
        
            <div class="flex justify-center items-center">
                <a href="login.php" class="text-sm lg:text-sm font-bold text-black hover:text-indigo-600">Login/</a>
                <a href="signin.php" class="text-sm lg:text-sm font-bold text-black hover:text-indigo-600">Signup</a>
            </div>
        </div>

        <li><a href="gst.php" class="text-lg font-bold text-black hover:text-indigo-600">Home</a></li>
        <li><a href="marketplace.php" class="text-lg font-bold text-black hover:text-indigo-600">Shop</a></li>
        <li><a href="clinic.php" class="text-lg font-bold text-black hover:text-indigo-600">Clinics</a></li>
        <li><a href="rescue.php" class="text-lg font-bold text-black hover:text-indigo-600">Resque Team</a></li>
        <li><a href="blog.php" class="text-lg font-bold text-black hover:text-indigo-600">Blog</a></li>
        <li><a href="adopt.php" class="text-lg font-bold text-black hover:text-indigo-600">Adopt</a></li>
        <li><a href="donation.php" class="text-lg font-bold text-black hover:text-indigo-600">Donate</a></li>
    </ul>


<header class="relative bg-gray-800 text-white py-20 md:py-60">
    <div class="absolute inset-0">
        <video autoplay muted loop playsinline class="w-full h-full object-cover opacity-40">
            <source src="img/videoplayback.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>
    <div class="relative container mx-auto px-6 text-center">
        <h1 class="text-4xl md:text-6xl font-bold leading-tight mb-4">Rescue. Heal. Protect. Love.</h1>
        <p class="text-lg md:text-xl max-w-3xl mx-auto mb-8 text-gray-200">A community dedicated to saving animals in need — from emergency rescue and medical help to finding them a forever home.</p>
        <div class="flex flex-col sm:flex-row justify-center items-center gap-4">
            <a href="rescue.php" class="w-full sm:w-auto px-8 py-4 bg-red-600 text-white font-bold rounded-lg shadow-lg hover:bg-red-700 transition transform hover:scale-105 animate-pulse">
                <i class="fa-solid fa-triangle-exclamation mr-2"></i> Report an Emergency
            </a>
            <a href="adopt.php" class="w-full sm:w-auto px-8 py-4 bg-indigo-600 text-white font-bold rounded-lg shadow-lg hover:bg-indigo-700 transition transform hover:scale-105">
                <i class="fa-solid fa-heart mr-2"></i> Adopt a Friend
            </a>
        </div>
    </div>
</header>


    <section class="py-16 bg-gradient-to-br from-indigo-50 to-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800">Our Mission & Services</h2>
                <p class="text-gray-600 mt-2 max-w-3xl mx-auto">Discover the core features of SavePaws and how we work to support animal welfare, connect communities, and make a difference.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                <a href="gst.php" class="group bg-white p-6 rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-2 transition-all duration-300 flex flex-col items-center text-center"><i class="fa-solid fa-home text-4xl text-indigo-600 mb-4 group-hover:scale-110 transition-transform"></i><h3 class="text-xl font-bold text-gray-900 mb-2">Home</h3><p class="text-gray-700">Explore the heart of SavePaws. Get an overview of our mission, latest updates, and quick access to all features.</p></a>
                <a href="marketplace.php" class="group bg-white p-6 rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-2 transition-all duration-300 flex flex-col items-center text-center"><i class="fa-solid fa-store text-4xl text-indigo-600 mb-4 group-hover:scale-110 transition-transform"></i><h3 class="text-xl font-bold text-gray-900 mb-2">Shop</h3><p class="text-gray-700">Find quality pet supplies. Every purchase directly supports our rescue and rehabilitation efforts.</p></a>
                <a href="clinic.php" class="group bg-white p-6 rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-2 transition-all duration-300 flex flex-col items-center text-center"><i class="fa-solid fa-stethoscope text-4xl text-indigo-600 mb-4 group-hover:scale-110 transition-transform"></i><h3 class="text-xl font-bold text-gray-900 mb-2">Clinics</h3><p class="text-gray-700">Locate nearby veterinary clinics and essential pet care services. Connect with trusted professionals.</p></a>
                <a href="rescue.php" class="group bg-white p-6 rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-2 transition-all duration-300 flex flex-col items-center text-center"><i class="fa-solid fa-truck-medical text-4xl text-indigo-600 mb-4 group-hover:scale-110 transition-transform"></i><h3 class="text-xl font-bold text-gray-900 mb-2">Rescue</h3><p class="text-gray-700">Report animals in distress and find local rescue teams. Your timely reports save lives.</p></a>
                <a href="blog.php" class="group bg-white p-6 rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-2 transition-all duration-300 flex flex-col items-center text-center"><i class="fa-solid fa-blog text-4xl text-indigo-600 mb-4 group-hover:scale-110 transition-transform"></i><h3 class="text-xl font-bold text-gray-900 mb-2">Blog</h3><p class="text-gray-700">Read inspiring success stories, get expert pet care tips, and stay updated on community events.</p></a>
                <a href="adopt.php" class="group bg-white p-6 rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-2 transition-all duration-300 flex flex-col items-center text-center"><i class="fa-solid fa-hand-heart text-4xl text-indigo-600 mb-4 group-hover:scale-110 transition-transform"></i><h3 class="text-xl font-bold text-gray-900 mb-2">Adopt</h3><p class="text-gray-700">Browse lovable pets seeking forever homes. Find your perfect companion through a caring process.</p></a>
                <a href="donation.php" class="group bg-white p-6 rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-2 transition-all duration-300 flex flex-col items-center text-center"><i class="fa-solid fa-donate text-4xl text-indigo-600 mb-4 group-hover:scale-110 transition-transform"></i><h3 class="text-xl font-bold text-gray-900 mb-2">Donate</h3><p class="text-gray-700">Support our mission financially. Your contributions directly fund animal rescues, medical care, and shelter operations.</p></a>
                <a href="https://t.me/savepaws_petcommunity" class="group bg-gradient-to-r from-indigo-500 to-purple-600 text-white p-6 rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-2 transition-all duration-300 flex flex-col items-center text-center"><i class="fa-solid fa-users-line text-4xl mb-4 group-hover:scale-110 transition-transform"></i><h3 class="text-xl font-bold mb-2">Community Forum</h3><p class="text-indigo-100">Connect with fellow animal lovers, share experiences, ask questions, and build a stronger community.</p></a>
            </div>
        </div>
    </section>

    <section class="gallery-section py-16">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800">Our Happy Tails Gallery</h2>
                <p class="text-gray-600 mt-2">Stories of hope, rescue, and love in pictures and videos.</p>
            </div>
            <div id="gallery-filters" class="flex justify-center items-center gap-2 mb-8">
                <button class="category-filter-btn active" data-filter="image">Images</button>
                <button class="category-filter-btn" data-filter="video">Videos</button>
            </div>
            <div class="swiper">
                <div class="swiper-wrapper"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
            <div class="text-center mt-8">
                <button id="show-gallery-btn" class="px-6 py-3 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 transition">See Full Gallery</button>
            </div>
        </div>
    </section>

    <section class="py-16 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800">What Our Community Says</h2>
                <p class="text-gray-600 mt-2 max-w-2xl mx-auto">Hear from the people who make our mission possible and the lives we've touched.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-gray-50 p-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 flex flex-col items-center text-center"><img src="https://randomuser.me/api/portraits/men/32.jpg" alt="User Avatar" class="w-20 h-20 rounded-full object-cover mb-4 ring-2 ring-indigo-600">
                    <h3 class="text-xl font-semibold text-gray-900 mb-1">John Doe</h3>
                    <p class="text-sm text-gray-500 mb-3">Adoptive Parent</p>
                    <div class="flex text-yellow-400 mb-4"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star-half-stroke"></i></div>
                    <p class="text-gray-700 italic">"SavePaws made adopting our beloved dog, Max, such a smooth and joyous experience. They truly care about these animals!"</p>
                </div>
                <div class="bg-gray-50 p-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 flex flex-col items-center text-center"><img src="https://randomuser.me/api/portraits/women/44.jpg" alt="User Avatar" class="w-20 h-20 rounded-full object-cover mb-4 ring-2 ring-indigo-600">
                    <h3 class="text-xl font-semibold text-gray-900 mb-1">Jane Smith</h3>
                    <p class="text-sm text-gray-500 mb-3">Volunteer</p>
                    <div class="flex text-yellow-400 mb-4"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                    <p class="text-gray-700 italic">"Volunteering with SavePaws has been incredibly rewarding. It's an amazing team, and every day I see the difference we make."</p>
                </div>
                <div class="bg-gray-50 p-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 flex flex-col items-center text-center"><img src="https://randomuser.me/api/portraits/men/75.jpg" alt="User Avatar" class="w-20 h-20 rounded-full object-cover mb-4 ring-2 ring-indigo-600">
                    <h3 class="text-xl font-semibold text-gray-900 mb-1">Michael Brown</h3>
                    <p class="text-sm text-gray-500 mb-3">Donor</p>
                    <div class="flex text-yellow-400 mb-4"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                    <p class="text-gray-700 italic">"I'm proud to support SavePaws. Their transparency and dedication to animal welfare are truly inspiring. Keep up the great work!"</p>
                </div>
            </div>
            <div class="text-center mt-8">
                <button id="show-feedback-btn" class="px-6 py-3 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 transition">Show All Feedback</button>
            </div>
        </div>
    </section>

    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800">Latest From Our Blog</h2>
                <p class="text-gray-600 mt-2 max-w-2xl mx-auto">Get the latest news, stories, and tips from the world of pet care.</p>
            </div>

            <div id="blog-filters" class="flex justify-center flex-wrap gap-2 mb-8">
                <button class="blog-filter-btn active" data-filter="all">All Posts</button>
                <button class="blog-filter-btn" data-filter="health">Health & Wellness</button>
                <button class="blog-filter-btn" data-filter="training">Training Tips</button>
                <button class="blog-filter-btn" data-filter="stories">Success Stories</button>
            </div>

            <div id="blog-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="blog-card bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300 flex flex-col" data-category="health">
                    <a href="blog.php#post1" class="block"><img src="https://images.unsplash.com/photo-1541364983171-a8ba01e95cfc?q=80&w=1887&auto=format&fit=crop" alt="A healthy dog smiling" class="w-full h-56 object-cover"></a>
                    <div class="p-6 flex flex-col flex-grow">
                        <span class="inline-block bg-indigo-100 text-indigo-800 text-xs font-semibold px-2.5 py-0.5 rounded-full mb-2 self-start">Health & Wellness</span>
                        <h3 class="text-xl font-bold text-gray-900 mb-2 hover:text-indigo-600 transition-colors"><a href="blog.php#post1">The 5 Signs of a Healthy Pet</a></h3>
                        <p class="text-gray-600 text-sm mb-4 flex-grow">Learn how to spot key indicators of your pet's well-being, from their coat to their energy levels.</p>
                        <div class="flex items-center text-sm text-gray-500 mt-auto pt-4 border-t border-gray-100">
                            <p>By Dr. Jane Foster - Oct 28, 2025</p>
                        </div>
                    </div>
                </div>

                <div class="blog-card bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300 flex flex-col" data-category="training">
                    <a href="blog.php#post2" class="block"><img src="https://images.unsplash.com/photo-1537151608828-ea2b11777ee8?q=80&w=1894&auto=format&fit=crop" alt="A person training a dog" class="w-full h-56 object-cover"></a>
                    <div class="p-6 flex flex-col flex-grow">
                        <span class="inline-block bg-purple-100 text-purple-800 text-xs font-semibold px-2.5 py-0.5 rounded-full mb-2 self-start">Training Tips</span>
                        <h3 class="text-xl font-bold text-gray-900 mb-2 hover:text-indigo-600 transition-colors"><a href="blog.php#post2">Positive Reinforcement: The Key to a Happy Pet</a></h3>
                        <p class="text-gray-600 text-sm mb-4 flex-grow">Discover effective and kind training techniques that build trust and strengthen your bond.</p>
                        <div class="flex items-center text-sm text-gray-500 mt-auto pt-4 border-t border-gray-100">
                            <p>By Alex Chen - Oct 25, 2025</p>
                        </div>
                    </div>
                </div>

                <div class="blog-card bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300 flex flex-col" data-category="stories">
                    <a href="blog.php#post3" class="block"><img src="img/luna.png" alt="A cat resting comfortably in a home" class="w-full h-56 object-cover"></a>
                    <div class="p-6 flex flex-col flex-grow">
                        <span class="inline-block bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded-full mb-2 self-start">Success Stories</span>
                        <h3 class="text-xl font-bold text-gray-900 mb-2 hover:text-indigo-600 transition-colors"><a href="blog.php#post3">From Street to Sweetheart: Luna's Journey</a></h3>
                        <p class="text-gray-600 text-sm mb-4 flex-grow">Read the heartwarming story of how a timid stray cat found her forever home and learned to trust again.</p>
                        <div class="flex items-center text-sm text-gray-500 mt-auto pt-4 border-t border-gray-100">
                            <p>By Maria Rodriguez - Oct 22, 2025</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-12">
                <a href="blog.php" class="px-8 py-3 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 transition-all duration-300 transform hover:scale-105">
                    View All Posts
                </a>
            </div>
        </div>
    </section>

    <hr class="container mx-auto px-6 border-t border-gray-200 my-8">
    <section class="py-16 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800">Frequently Asked Questions</h2>
            </div>
            <div class="max-w-3xl mx-auto space-y-4">
                <div class="faq-item border border-gray-200 rounded-lg">
                    <div class="faq-question flex justify-between items-center p-5 cursor-pointer">
                        <h4 class="font-semibold text-lg text-gray-800">How do I report an animal in need?</h4><i class="fa-solid fa-plus icon-plus text-indigo-600 transition-transform"></i></div>
                    <div class="faq-answer px-5 pb-5 text-gray-600">
                        <p>Click the red "Report an Emergency" button on our homepage or navigate to the 'Rescue' page. Fill out the form with as much detail as possible, including the location and condition of the animal.</p>
                    </div>
                </div>
                <div class="faq-item border border-gray-200 rounded-lg">
                    <div class="faq-question flex justify-between items-center p-5 cursor-pointer">
                        <h4 class="font-semibold text-lg text-gray-800">What is the adoption process like?</h4><i class="fa-solid fa-plus icon-plus text-indigo-600 transition-transform"></i></div>
                    <div class="faq-answer px-5 pb-5 text-gray-600">
                        <p>Visit our 'Adopt' page to see available pets. You can fill out an application form online. Our team will review it and contact you to arrange a meet-and-greet to ensure it's a perfect match for both you and the pet.</p>
                    </div>
                </div>
                <div class="faq-item border border-gray-200 rounded-lg">
                    <div class="faq-question flex justify-between items-center p-5 cursor-pointer">
                        <h4 class="font-semibold text-lg text-gray-800">How can I volunteer?</h4><i class="fa-solid fa-plus icon-plus text-indigo-600 transition-transform"></i></div>
                    <div class="faq-answer px-5 pb-5 text-gray-600">
                        <p>We'd love to have you! Please visit our 'Get Involved' page or contact us directly. We have many roles available, from helping at shelters to assisting with transport and administrative tasks.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-indigo-700 text-white">
        <div class="container mx-auto px-6 py-16 text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Join Our Mission to Save Lives</h2>
            <p class="text-indigo-200 max-w-2xl mx-auto mb-8">Whether you choose to adopt, donate, or volunteer, your support makes a world of difference. Together, we can give them a second chance.</p>
            <div class="flex flex-col sm:flex-row justify-center items-center gap-4"><a href="donation.php" class="w-full sm:w-auto px-8 py-4 bg-yellow-400 text-gray-900 font-bold rounded-lg shadow-lg hover:bg-yellow-300 transition transform hover:scale-105">Donate Now</a><a href="#" class="w-full sm:w-auto px-8 py-4 bg-white text-indigo-700 font-bold rounded-lg shadow-lg hover:bg-gray-100 transition transform hover:scale-105">Become a Volunteer</a></div>
        </div>
    </section>

    <footer class="bg-[#1A253DF0] text-white py-12 px-6 w-full">
        <div class="max-w-6xl mx-auto">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10 text-center sm:text-left">
                <section>
                    <h3 class="text-xl md:text-2xl font-bold mb-4">Company</h3>
                    <ul class="space-y-2 text-gray-300">
                        <li><a href="#" class="hover:text-white transition-colors">About Us</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Why Choose Us</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Pricing</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Testimonials</a></li>
                    </ul>
                </section>
                <section>
                    <h3 class="text-xl md:text-2xl font-bold mb-4">Resources</h3>
                    <ul class="space-y-2 text-gray-300">
                        <li><a href="#" class="hover:text-white transition-colors">Privacy Policy</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Terms & Conditions</a></li>
                        <li><a href="blog.php" class="hover:text-white transition-colors">Blog</a></li>
                        <li><a href="tel:+8801727898421" class="hover:text-white transition-colors">Contact Us</a></li>
                    </ul>
                </section>
                <section>
                    <h3 class="text-xl md:text-2xl font-bold mb-4">Product</h3>
                    <ul class="space-y-2 text-gray-300">
                        <li><a href="#" class="hover:text-white transition-colors">Project Management</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Time Tracker</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Time Schedule</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Lead Generate</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Remote Collaboration</a></li>
                    </ul>
                </section>
                <section>
                    <h3 class="text-2xl md:text-3xl font-bold mb-4">SavePaws Club</h3>
                    <p class="text-gray-300 mb-4">Subscribe to our Newsletter</p>
                    <form class="flex flex-col sm:flex-col gap-2">
                        <input type="text" placeholder="Drop Your Feedback" class="bg-black flex-1 px-4 py-3 rounded-md border border-gray-600 focus:outline-none focus:ring-2 focus:ring-white text-white placeholder-gray-400">
                        <button type="submit" class="bg-white text-[#1A253D] px-4 py-3 rounded-md font-semibold hover:bg-gray-200 transition-colors">
                            Feedback
                        </button>
                    </form>
                </section>
            </div>
            <hr class="border-gray-700 my-10">
            <div class="flex flex-col sm:flex-row items-center justify-between text-gray-300 text-sm">
                <p class="text-lg">&copy; 2025 SavePaws. All rights reserved.</p>
                <div class="flex space-x-5 mt-4 sm:mt-0">
                    <a href="#" class="hover:text-white transition"><i class="fab fa-facebook-f text-xl"></i></a>
                    <a href="#" class="hover:text-white transition"><i class="fab fa-twitter text-xl"></i></a>
                    <a href="#" class="hover:text-white transition"><i class="fab fa-instagram text-xl"></i></a>
                    <a href="#" class="hover:text-white transition"><i class="fab fa-linkedin-in text-xl"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <div id="lightbox" class="fixed inset-0 bg-black bg-opacity-80 flex items-center justify-center p-4 z-[9999] hidden">
        <div id="lightbox-content" class="relative max-w-4xl max-h-[90vh]"></div>
        <button id="lightbox-close" class="absolute top-4 right-4 text-white text-4xl">&times;</button>
    </div>

    <section id="full-gallery-page" class="fixed inset-0 bg-gray-100 z-[100] p-6 overflow-y-auto hidden transition-opacity duration-300 opacity-0">
        <div class="container mx-auto max-w-7xl">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-3xl font-bold text-gray-800">Our Full Gallery</h2>
                <button id="close-gallery-btn" class="text-3xl text-gray-500 hover:text-gray-800 transition">&times;</button>
            </div>
            <div id="full-gallery-filters" class="flex justify-center items-center gap-2 mb-8">
                <button class="category-filter-btn active" data-filter="all">All</button>
                <button class="category-filter-btn" data-filter="image">Images</button>
                <button class="category-filter-btn" data-filter="video">Videos</button>
            </div>
            <div id="full-gallery-grid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                </div>
        </div>
    </section>

    <section id="full-feedback-page" class="fixed inset-0 bg-white z-[100] p-6 overflow-y-auto hidden transition-opacity duration-300 opacity-0">
        <div class="container mx-auto max-w-7xl">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-3xl font-bold text-gray-800">Community Feedback</h2>
                <button id="close-feedback-btn" class="text-3xl text-gray-500 hover:text-gray-800 transition">&times;</button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-gray-50 p-6 rounded-xl shadow-md flex flex-col items-center text-center"><img src="https://randomuser.me/api/portraits/men/32.jpg" alt="User Avatar" class="w-20 h-20 rounded-full object-cover mb-4 ring-2 ring-indigo-600">
                    <h3 class="text-xl font-semibold text-gray-900 mb-1">John Doe</h3>
                    <p class="text-sm text-gray-500 mb-3">Adoptive Parent</p>
                    <div class="flex text-yellow-400 mb-4"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star-half-stroke"></i></div>
                    <p class="text-gray-700 italic">"SavePaws made adopting our beloved dog, Max, such a smooth and joyous experience. They truly care about these animals!"</p>
                </div>
                <div class="bg-gray-50 p-6 rounded-xl shadow-md flex flex-col items-center text-center"><img src="https://randomuser.me/api/portraits/women/44.jpg" alt="User Avatar" class="w-20 h-20 rounded-full object-cover mb-4 ring-2 ring-indigo-600">
                    <h3 class="text-xl font-semibold text-gray-900 mb-1">Jane Smith</h3>
                    <p class="text-sm text-gray-500 mb-3">Volunteer</p>
                    <div class="flex text-yellow-400 mb-4"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                    <p class="text-gray-700 italic">"Volunteering with SavePaws has been incredibly rewarding. It's an amazing team, and every day I see the difference we make."</p>
                </div>
                <div class="bg-gray-50 p-6 rounded-xl shadow-md flex flex-col items-center text-center"><img src="https://randomuser.me/api/portraits/men/75.jpg" alt="User Avatar" class="w-20 h-20 rounded-full object-cover mb-4 ring-2 ring-indigo-600">
                    <h3 class="text-xl font-semibold text-gray-900 mb-1">Michael Brown</h3>
                    <p class="text-sm text-gray-500 mb-3">Donor</p>
                    <div class="flex text-yellow-400 mb-4"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                    <p class="text-gray-700 italic">"I'm proud to support SavePaws. Their transparency and dedication to animal welfare are truly inspiring. Keep up the great work!"</p>
                </div>
                <div class="bg-gray-50 p-6 rounded-xl shadow-md flex flex-col items-center text-center"><img src="https://randomuser.me/api/portraits/women/8.jpg" alt="User Avatar" class="w-20 h-20 rounded-full object-cover mb-4 ring-2 ring-indigo-600">
                    <h3 class="text-xl font-semibold text-gray-900 mb-1">Emily Wilson</h3>
                    <p class="text-sm text-gray-500 mb-3">Foster Parent</p>
                    <div class="flex text-yellow-400 mb-4"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                    <p class="text-gray-700 italic">"The support from the community forum was invaluable when I fostered my first kitten. Everyone is so helpful and knowledgeable."</p>
                </div>
                <div class="bg-gray-50 p-6 rounded-xl shadow-md flex flex-col items-center text-center"><img src="https://randomuser.me/api/portraits/men/22.jpg" alt="User Avatar" class="w-20 h-20 rounded-full object-cover mb-4 ring-2 ring-indigo-600">
                    <h3 class="text-xl font-semibold text-gray-900 mb-1">David Lee</h3>
                    <p class="text-sm text-gray-500 mb-3">Rescuer</p>
                    <div class="flex text-yellow-400 mb-4"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="far fa-star"></i></div>
                    <p class="text-gray-700 italic">"Using the rescue feature, I was able to get help for a stray dog in my neighborhood within an hour. The system works flawlessly."</p>
                </div>
                <div class="bg-gray-50 p-6 rounded-xl shadow-md flex flex-col items-center text-center"><img src="https://randomuser.me/api/portraits/women/65.jpg" alt="User Avatar" class="w-20 h-20 rounded-full object-cover mb-4 ring-2 ring-indigo-600">
                    <h3 class="text-xl font-semibold text-gray-900 mb-1">Sarah Garcia</h3>
                    <p class="text-sm text-gray-500 mb-3">Blog Reader</p>
                    <div class="flex text-yellow-400 mb-4"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                    <p class="text-gray-700 italic">"I love reading the success stories on the blog. It brightens my day and reinforces my belief in the good people are doing."</p>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            let swiper = null;

            const allSlidesData = [{
                category: 'image',
                type: 'image',
                src: 'img/nutrition.png',
                alt: 'Curious kitten looking up'
            }, {
                category: 'image',
                type: 'image',
                src: 'https://images.unsplash.com/photo-1534361960057-19889db9621e?q=80&w=2070&auto=format&fit=crop',
                alt: 'Happy dog with sunglasses'
            }, {
                category: 'video',
                type: 'video',
                src: 'https://www.youtube.com/embed/1vrEljMfXYo?autoplay=1&mute=1&loop=1&playlist=1vrEljMfXYo',
                thumbnail: 'https://img.youtube.com/vi/1vrEljMfXYo/0.jpg',
                alt: 'Funny and cute pet moments'
            }, {
                category: 'image',
                type: 'image',
                src: 'https://images.unsplash.com/photo-1596854407944-bf87f6fdd49e?q=80&w=1780&auto=format&fit=crop',
                alt: 'Cat peeking from a corner'
            }, {
                category: 'image',
                type: 'image',
                src: 'https://images.unsplash.com/photo-1583511655857-d19b40a7a54e?q=80&w=2070&auto=format&fit=crop',
                alt: 'Joyful dog running in a field'
            }, {
                category: 'video',
                type: 'video',
                src: 'https://www.youtube.com/embed/j_n4Xb-T71M?autoplay=1&mute=1&loop=1&playlist=j_n4Xb-T71M',
                thumbnail: 'https://img.youtube.com/vi/j_n4Xb-T71M/0.jpg',
                alt: 'Adorable puppies compilation'
            }, {
                category: 'image',
                type: 'image',
                src: 'https://images.unsplash.com/photo-1517849845537-4d257902454a?q=80&w=1935&auto=format&fit=crop',
                alt: 'A pug in a stylish jacket'
            }, {
                category: 'video',
                type: 'video',
                src: 'https://www.youtube.com/embed/4nC0O1-S9gI?autoplay=1&mute=1&loop=1&playlist=4nC0O1-S9gI',
                thumbnail: 'https://img.youtube.com/vi/4nC0O1-S9gI/0.jpg',
                alt: 'Heartwarming kitten moments'
            }, {
                category: 'image',
                type: 'image',
                src: 'https://images.unsplash.com/photo-1573865526739-10659fec78a5?q=80&w=1915&auto=format&fit=crop',
                alt: 'A cat with striking blue eyes'
            }];

            const createSlideElement = (slideData) => {
                const slide = document.createElement('div');
                slide.className = 'swiper-slide';
                slide.dataset.category = slideData.category;
                slide.dataset.type = slideData.type;
                slide.dataset.src = slideData.src;

                const img = document.createElement('img');
                img.src = slideData.type === 'image' ? slideData.src : slideData.thumbnail;
                img.alt = slideData.alt;
                slide.appendChild(img);

                if (slideData.type === 'video') {
                    const playIcon = document.createElement('div');
                    playIcon.className = 'play-icon absolute inset-0 bg-black bg-opacity-30 flex items-center justify-center';
                    playIcon.innerHTML = `<i class="fa-solid fa-play text-white text-5xl"></i>`;
                    slide.appendChild(playIcon);
                }
                return slide;
            };

            const initializeSwiper = (slidesData) => {
                if (swiper) swiper.destroy(true, true);
                const swiperWrapper = document.querySelector('.swiper-wrapper');
                swiperWrapper.innerHTML = '';
                slidesData.forEach(data => swiperWrapper.appendChild(createSlideElement(data)));

                swiper = new Swiper('.swiper', {
                    effect: 'coverflow',
                    grabCursor: true,
                    centeredSlides: true,
                    slidesPerView: 'auto',
                    loop: slidesData.length > 2,
                    coverflowEffect: {
                        rotate: 5,
                        stretch: -25,
                        depth: 100,
                        modifier: 1.2,
                        slideShadows: true,
                    },
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev',
                    },
                });
            };

            const filterSlides = (filter) => {
                const slidesToDisplay = allSlidesData.filter(slide => slide.category === filter);
                initializeSwiper(slidesToDisplay);
            };

            document.querySelectorAll('#gallery-filters .category-filter-btn').forEach(button => {
                button.addEventListener('click', () => {
                    document.querySelectorAll('#gallery-filters .category-filter-btn').forEach(btn => btn.classList.remove('active'));
                    button.classList.add('active');
                    filterSlides(button.dataset.filter);
                });
            });

            const blogFilterButtons = document.querySelectorAll('.blog-filter-btn');
            const blogCards = document.querySelectorAll('.blog-card');
            blogFilterButtons.forEach(button => {
                button.addEventListener('click', () => {
                    blogFilterButtons.forEach(btn => btn.classList.remove('active'));
                    button.classList.add('active');
                    const filter = button.dataset.filter;
                    blogCards.forEach(card => {
                        card.style.display = (filter === 'all' || card.dataset.category === filter) ? 'flex' : 'none';
                    });
                });
            });

            const lightbox = document.getElementById('lightbox');
            const lightboxContent = document.getElementById('lightbox-content');
            const lightboxClose = document.getElementById('lightbox-close');
            const openLightbox = (type, src) => {
                lightboxContent.innerHTML = '';
                if (type === 'image') {
                    lightboxContent.innerHTML = `<img src="${src}" class="max-w-full max-h-[90vh] rounded-lg">`;
                } else if (type === 'video') {
                    lightboxContent.innerHTML = `<iframe src="${src}" class="w-[80vw] h-[45vw] max-w-4xl max-h-[80vh] rounded-lg" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>`;
                }
                lightbox.classList.remove('hidden');
            };
            const closeLightbox = () => {
                lightbox.classList.add('hidden');
                lightboxContent.innerHTML = '';
            };
            document.querySelector('.swiper')?.addEventListener('click', (e) => {
                const clickedSlide = e.target.closest('.swiper-slide-active');
                if (clickedSlide) {
                    openLightbox(clickedSlide.dataset.type, clickedSlide.dataset.src);
                }
            });
            lightboxClose.addEventListener('click', closeLightbox);
            lightbox.addEventListener('click', (e) => {
                if (e.target === lightbox) closeLightbox();
            });

            const showGalleryBtn = document.getElementById('show-gallery-btn');
            const fullGalleryPage = document.getElementById('full-gallery-page');
            const closeGalleryBtn = document.getElementById('close-gallery-btn');
            const fullGalleryGrid = document.getElementById('full-gallery-grid');
            const showFeedbackBtn = document.getElementById('show-feedback-btn');
            const fullFeedbackPage = document.getElementById('full-feedback-page');
            const closeFeedbackBtn = document.getElementById('close-feedback-btn');

            const openOverlay = (page) => {
                page.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
                setTimeout(() => page.classList.remove('opacity-0'), 10);
            };
            const closeOverlay = (page) => {
                page.classList.add('opacity-0');
                document.body.style.overflow = '';
                setTimeout(() => page.classList.add('hidden'), 300);
            };

            const populateFullGallery = (filter) => {
                fullGalleryGrid.innerHTML = '';
                const itemsToShow = (filter === 'all') ? allSlidesData : allSlidesData.filter(item => item.category === filter);

                itemsToShow.forEach(data => {
                    const card = document.createElement('div');
                    card.className = 'bg-white rounded-lg shadow-md overflow-hidden group cursor-pointer';
                    card.dataset.type = data.type;
                    card.dataset.src = data.src;

                    let cardContent = `
                        <div class="relative">
                            <img src="${data.type === 'image' ? data.src : data.thumbnail}" alt="${data.alt}" class="w-full h-48 object-cover transition-transform duration-300 group-hover:scale-110">
                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 transition-all duration-300 flex items-center justify-center">
                    `;

                    if (data.type === 'video') {
                        cardContent += `<i class="fa-solid fa-play text-white text-5xl opacity-80"></i>`;
                    } else {
                        cardContent += `<i class="fa-solid fa-magnifying-glass-plus text-white text-5xl opacity-0 group-hover:opacity-80 transition-opacity duration-300"></i>`;
                    }

                    cardContent += `
                            </div>
                        </div>
                        <div class="p-4">
                            <p class="text-sm text-gray-800 font-semibold truncate">${data.alt}</p>
                        </div>
                    `;
                    card.innerHTML = cardContent;
                    fullGalleryGrid.appendChild(card);
                });
            };

            showGalleryBtn.addEventListener('click', () => {
                populateFullGallery('all');
                document.querySelector('#full-gallery-filters .category-filter-btn.active').classList.remove('active');
                document.querySelector('#full-gallery-filters .category-filter-btn[data-filter="all"]').classList.add('active');
                openOverlay(fullGalleryPage);
            });

            document.querySelectorAll('#full-gallery-filters .category-filter-btn').forEach(button => {
                button.addEventListener('click', () => {
                    document.querySelectorAll('#full-gallery-filters .category-filter-btn').forEach(btn => btn.classList.remove('active'));
                    button.classList.add('active');
                    populateFullGallery(button.dataset.filter);
                });
            });

            closeGalleryBtn.addEventListener('click', () => closeOverlay(fullGalleryPage));
            fullGalleryGrid.addEventListener('click', (e) => {
                const item = e.target.closest('[data-type]');
                if (item) {
                    openLightbox(item.dataset.type, item.dataset.src);
                }
            });

            showFeedbackBtn.addEventListener('click', () => openOverlay(fullFeedbackPage));
            closeFeedbackBtn.addEventListener('click', () => closeOverlay(fullFeedbackPage));

            const menuBtn = document.getElementById('menu-btn');
            const mobileMenu = document.getElementById('mobile-menu');
            if (menuBtn) {
                menuBtn.addEventListener('click', () => mobileMenu.classList.toggle('hidden'));
            }
            document.querySelectorAll('.faq-item').forEach(item => {
                const q = item.querySelector('.faq-question');
                q?.addEventListener('click', () => {
                    const isOpen = item.classList.contains('open');
                    document.querySelectorAll('.faq-item').forEach(other => other.classList.remove('open'));
                    if (!isOpen) {
                        item.classList.add('open');
                    }
                });
            });

            document.querySelector('#gallery-filters .category-filter-btn[data-filter="image"]').click();
        });
    </script>
</body>

</html>