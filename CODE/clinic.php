<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clinic Search Results</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer"
    />

    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Define custom colors to match the screenshot design */
        
        .bg-custom-purple {
            background-color: #6c5ce7;
        }
        
        .text-custom-purple {
            color: #6c5ce7;
        }
        
        .hover\:text-custom-purple:hover {
            color: #6c5ce7;
        }

        .bg-custom-blue {
            background-color: #4a69bd;
        }
        
        .text-custom-blue {
            color: #4a69bd;
        }
        
        .hover\:bg-custom-blue:hover {
            background-color: #4a69bd;
        }

        .bg-light-gray {
            background-color: #f7f7f7;
        }
    </style>
</head>

<body class="bg-white">

    <nav class="flex flex-wrap justify-between items-center py-4 bg-white shadow-lg">
        <h1 class="font-semibold md:text-xl text-lg text-sky-500 my-auto ml-5"><i class="fa-solid fa-paw text-amber-950"></i>SavePaws</h1>
        <ul class="hidden lg:flex mx-auto justify-around flex-wrap">
            <li><a href="gst.php" class="text-sm lg:text-sm font-bold text-black hover:text-indigo-600 lg:p-5 transform transition-transform hover:scale-120">Home</a></li>
            <li><a href="marketplace.php" class="text-sm lg:text-sm font-bold text-black hover:text-indigo-600 lg:p-5 transform transition-transform hover:scale-120">Shop</a></li>
            <li><a href="clinic.php" class="text-sm lg:text-sm font-bold text-black hover:text-indigo-600 lg:p-5 transform transition-transform hover:scale-120">Clinics</a></li>
            <li><a href="rescue.php" class="text-sm lg:text-sm font-bold text-black hover:text-indigo-600 lg:p-5 transform transition-transform hover:scale-120">Rescue</a></li>
            <li><a href="blog.php" class="text-sm lg:text-sm font-bold text-black hover:text-indigo-600 lg:p-5 transform transition-transform hover:scale-120">Blog</a></li>
            <li><a href="adopt.php" class="text-sm lg:text-sm font-bold text-black hover:text-indigo-600 lg:p-5 transform transition-transform hover:scale-120">Adopt</a></li>
            <li><a href="donation.php" class="text-sm lg:text-sm font-bold text-black hover:text-indigo-600 lg:p-5 transform transition-transform hover:scale-120">Donate</a></li>
        </ul>


        <div class=" hidden lg:flex sm:hidden items-center space-x-2 lg:space-x-5 mr-5">
            
            <div class="flex justify-center items-center">
                <a href="login.php" class="text-sm lg:text-sm font-bold text-black hover:text-indigo-600">Logout</a>
            </div>
            <div class="rounded-full bg-slate-300 shadow-md w-10 h-10 lg:w-12 lg:h-12 flex items-center justify-center text-xs lg:text-base">Img</div>
        </div>

        <button id="menu-btn" class="lg:hidden text-xl text-black mr-5">
            <i class="fa-solid fa-bars"></i>
        </button>
    </nav>

    <ul id="mobile-menu" class="hidden flex-col space-y-4 border-t-4 border-gray-500 bg-white shadow-md p-6 lg:hidden">

        <div class="flex items-center justify-evenly space-x-2 lg:space-x-5 bg-gray-200 rounded-2xl py-2">
            <div class="rounded-full bg-slate-300 shadow-md w-20 h-20 lg:w-12 lg:h-12 flex items-center justify-center text-sm lg:text-base">Img</div>

        
            <div class="flex justify-center items-center">
                <a href="login.php" class="text-sm lg:text-sm font-bold text-black hover:text-indigo-600">Login/</a>
                <a href="signup.php" class="text-sm lg:text-sm font-bold text-black hover:text-indigo-600">Signup</a>
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

    <hr class="border-gray-100">

    <header class="relative bg-gray-800 text-white py-20 h-[85vh] flex items-center justify-center">
        <div class="absolute inset-0">
            <video autoplay muted loop playsinline class="w-full h-full object-cover opacity-40">
                <source src="img/clinic_1.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>
        <div class="relative z-10 flex flex-col items-center max-w-4xl mx-auto px-4 text-center">
            <h1 class="font-serif text-3xl sm:text-4xl md:text-5xl lg:text-7xl text-white leading-tight mb-6">
                "Rescue. Heal. Protect. Love"
            </h1>
            <p class="text-base sm:text-lg md:text-xl text-white leading-relaxed mb-10 max-w-2xl">
                A community to save animals in need — from rescue & medical help to volunteer support, awareness, and donations.
            </p>

            <div class="flex flex-col sm:flex-row justify-center items-center gap-5 sm:gap-8">
                <button onclick="window.location.href='firstaid.php'" class="px-8 py-4 bg-custom-purple text-white font-bold rounded-full shadow-lg transform transition-all duration-300 hover:scale-105 hover:bg-custom-blue focus:outline-none focus:ring-4 focus:ring-purple-300 w-64 sm:w-auto">
                    <i class="fas fa-first-aid mr-2"></i> First Aid
                </button>

                <button onclick="window.location.href='enjoy_service.php'" class="px-8 py-4 bg-transparent border-2 border-white text-white font-bold rounded-full shadow-lg transform transition-all duration-300 hover:scale-105 hover:bg-white hover:text-custom-purple focus:outline-none focus:ring-4 focus:ring-gray-300 w-64 sm:w-auto">
                    <i class="fas fa-concierge-bell mr-2"></i> Enjoy Service
                </button>
            </div>
        </div>
    </header>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative my-10 py-5 shadow-2xl">
        <input type="text" id="search-input" placeholder="Find your Location" class="rounded-xl w-full py-4 pl-8 pr-12 text-lg border-2 border-black shadow-sm focus:ring-primary-indigo focus:ring-2 focus:border-primary-indigo">
        <svg class="h-6 w-6 absolute top-1/2 right-10 -translate-y-1/2 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
    </div>

    <section class="container mx-auto px-4 pb-20">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">results</h2>

        <div id="clinic-cards" class="space-y-6">

            <div class="bg-light-gray p-4 md:p-6 rounded-2xl shadow-md flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-6 items-center clinic-card">
                <div class="flex-shrink-0 w-full md:w-60 h-40 rounded-xl overflow-hidden">
                    <img src="img/BACC.png" alt="Veterinarian New Braunfels exterior" class="w-full h-full object-cover" />
                </div>
                <div class="flex-grow grid grid-cols-1 lg:grid-cols-3 gap-4 w-full">
                    <div class="lg:col-span-1">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Bangladesh Animal Care Center (BACC)</h3>
                        <div class="space-y-1 text-gray-600 text-sm">
                            <p class="flex items-center"><svg class="w-4 h-4 mr-2 text-custom-purple" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>                                 House no: 24, Road No # 36, Dhaka 1212</p>
                            <p class="flex items-center"><svg class="w-4 h-4 mr-2 text-custom-purple" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>                                 +880 1770-476749</p>
                            <p class="flex items-center"><svg class="w-4 h-4 mr-2 text-custom-purple" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM12 17a6 6 0 00-6-6v4H6m-2-4v4h2"></path></svg>Dr.
                                 Jake Grey</p>
                        </div>
                    </div>
                    <div class="lg:col-span-1 border-t md:border-t-0 md:border-l border-gray-300 md:pl-6 pt-4 md:pt-0">
                        <p class="text-base font-semibold text-gray-800 mb-2">8:00 AM - 7:00 PM</p>
                        <p class="text-sm text-gray-600">
                            Sat <span class="font-bold text-custom-purple">Sun Mon Tu</span> Wed Thu <span class="font-bold text-custom-purple">Fri</span>
                        </p>
                    </div>
                    <div class="lg:col-span-1 flex items-center justify-start md:justify-end">
                        <button onclick="window.location.href='appoinment.php'" class="bg-custom-purple text-white px-6 py-2 rounded-lg font-medium shadow-md hover:bg-custom-blue transition duration-300 w-full md:w-auto">
                            view doctors & schedules
                        </button>
                    </div>
                </div>
            </div>

            <div class="bg-light-gray p-4 md:p-6 rounded-2xl shadow-md flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-6 items-center clinic-card">
                <div class="flex-shrink-0 w-full md:w-60 h-40 rounded-xl overflow-hidden">
                    <img src="img/anwar.png" alt="Veterinarian New Braunfels exterior" class="w-full h-full object-cover" />
                </div>
                <div class="flex-grow grid grid-cols-1 lg:grid-cols-3 gap-4 w-full">
                    <div class="lg:col-span-1">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Dr. Anawar's Pet Care - Veterinary Clinic</h3>
                        <div class="space-y-1 text-gray-600 text-sm">
                            <p class="flex items-center"><svg class="w-4 h-4 mr-2 text-custom-purple" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>                                 House#11 Road#04, Dhaka 1229</p>
                            <p class="flex items-center"><svg class="w-4 h-4 mr-2 text-custom-purple" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>                                 +880 1723-256771
                            </p>
                            <p class="flex items-center"><svg class="w-4 h-4 mr-2 text-custom-purple" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM12 17a6 6 0 00-6-6v4H6m-2-4v4h2"></path></svg>Dr.
                                 Jake Grey</p>
                        </div>
                    </div>
                    <div class="lg:col-span-1 border-t md:border-t-0 md:border-l border-gray-300 md:pl-6 pt-4 md:pt-0">
                        <p class="text-base font-semibold text-gray-800 mb-2">8:00 AM - 7:00 PM</p>
                        <p class="text-sm text-gray-600">
                            Sat <span class="font-bold text-custom-purple">Sun Mon Tu</span> Wed Thu <span class="font-bold text-custom-purple">Fri</span>
                        </p>
                    </div>
                    <div class="lg:col-span-1 flex items-center justify-start md:justify-end">
                        <button onclick="window.location.href='appoinment.php'" class="bg-custom-purple text-white px-6 py-2 rounded-lg font-medium shadow-md hover:bg-custom-blue transition duration-300 w-full md:w-auto">
                            view doctors & schedules
                        </button>
                    </div>
                </div>
            </div>

            <div class="bg-light-gray p-4 md:p-6 rounded-2xl shadow-md flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-6 items-center clinic-card">
                <div class="flex-shrink-0 w-full md:w-60 h-40 rounded-xl overflow-hidden">
                    <img src="img/bala.png" alt="Veterinarian New Braunfels exterior" class="w-full h-full object-cover" />
                </div>
                <div class="flex-grow grid grid-cols-1 lg:grid-cols-3 gap-4 w-full">
                    <div class="lg:col-span-1">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Bala G Pet Clinic</h3>
                        <div class="space-y-1 text-gray-600 text-sm">
                            <p class="flex items-center"><svg class="w-4 h-4 mr-2 text-custom-purple" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>                                 364 DIT Rd, Dhaka 1219</p>
                            <p class="flex items-center"><svg class="w-4 h-4 mr-2 text-custom-purple" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>                                 +880 1881-227204
                            </p>
                            <p class="flex items-center"><svg class="w-4 h-4 mr-2 text-custom-purple" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM12 17a6 6 0 00-6-6v4H6m-2-4v4h2"></path></svg>Dr.
                                 Jake Grey</p>
                        </div>
                    </div>
                    <div class="lg:col-span-1 border-t md:border-t-0 md:border-l border-gray-300 md:pl-6 pt-4 md:pt-0">
                        <p class="text-base font-semibold text-gray-800 mb-2">8:00 AM - 7:00 PM</p>
                        <p class="text-sm text-gray-600">
                            Sat <span class="font-bold text-custom-purple">Sun Mon Tu</span> Wed Thu <span class="font-bold text-custom-purple">Fri</span>
                        </p>
                    </div>
                    <div class="lg:col-span-1 flex items-center justify-start md:justify-end">
                        <button onclick="window.location.href='appoinment.php'" class="bg-custom-purple text-white px-6 py-2 rounded-lg font-medium shadow-md hover:bg-custom-blue transition duration-300 w-full md:w-auto">
                            view doctors & schedules
                        </button>
                    </div>
                </div>
            </div>

            <div class="bg-light-gray p-4 md:p-6 rounded-2xl shadow-md flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-6 items-center clinic-card">
                <div class="flex-shrink-0 w-full md:w-60 h-40 rounded-xl overflow-hidden">
                    <img src="img/pet and bird.png" alt="Veterinarian New Braunfels exterior" class="w-full h-full object-cover" />
                </div>
                <div class="flex-grow grid grid-cols-1 lg:grid-cols-3 gap-4 w-full">
                    <div class="lg:col-span-1">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Pet And Bird Care</h3>
                        <div class="space-y-1 text-gray-600 text-sm">
                            <p class="flex items-center"><svg class="w-4 h-4 mr-2 text-custom-purple" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>House-
                                 13/14, Lane- 1, Block- A, Mirpu 6, ঢাকা 1216</p>
                            <p class="flex items-center"><svg class="w-4 h-4 mr-2 text-custom-purple" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>+880
                                 1701-073107
                            </p>
                            <p class="flex items-center"><svg class="w-4 h-4 mr-2 text-custom-purple" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM12 17a6 6 0 00-6-6v4H6m-2-4v4h2"></path></svg>Dr.
                                 Jake Grey</p>
                        </div>
                    </div>
                    <div class="lg:col-span-1 border-t md:border-t-0 md:border-l border-gray-300 md:pl-6 pt-4 md:pt-0">
                        <p class="text-base font-semibold text-gray-800 mb-2">8:00 AM - 7:00 PM</p>
                        <p class="text-sm text-gray-600">
                            Sat <span class="font-bold text-custom-purple">Sun Mon Tu</span> Wed Thu <span class="font-bold text-custom-purple">Fri</span>
                        </p>
                    </div>
                    <div class="lg:col-span-1 flex items-center justify-start md:justify-end">
                        <button onclick="window.location.href='appoinment.php'" class="bg-custom-purple text-white px-6 py-2 rounded-lg font-medium shadow-md hover:bg-custom-blue transition duration-300 w-full md:w-auto">
                            view doctors & schedules
                        </button>
                    </div>
                </div>
            </div>
            
        </div>

        <div class="text-center mt-8">
            <button id="view-more-btn" onclick="showMoreCards()" class="text-custom-purple border border-custom-purple px-6 py-3 rounded-lg font-medium hover:bg-custom-purple hover:text-white transition duration-300">
                view more
            </button>
        </div>
    </section>

    <footer class="bg-[#1A253DF0] text-white py-12 px-4 w-full">
        <div class="container mx-auto max-w-7xl">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 w-full gap-8 text-center sm:text-left">
                <div>
                    <h3 class="text-xl md:text-2xl font-bold mb-4">Company</h3>
                    <ul class="space-y-2 text-gray-300">
                        <li><a href="#" class="hover:text-white transition-colors duration-300">About Us</a></li>
                        <li><a href="#" class="hover:text-white transition-colors duration-300">Why Choose us</a></li>
                        <li><a href="#" class="hover:text-white transition-colors duration-300">Pricing</a></li>
                        <li><a href="#" class="hover:text-white transition-colors duration-300">Testimonial</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-xl md:text-2xl font-bold mb-4">Resources</h3>
                    <ul class="space-y-2 text-gray-300">
                        <li><a href="#" class="hover:text-white transition-colors duration-300">Privacy Policy</a></li>
                        <li><a href="#" class="hover:text-white transition-colors duration-300">Terms and Condition</a></li>
                        <li><a href="blog.php" class="hover:text-white transition-colors duration-300">Blog</a></li>
                        <li><a href="tel:+8801727898421" class="hover:text-white transition-colors duration-300">Contact Us</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-xl md:text-2xl font-bold mb-4">Product</h3>
                    <ul class="space-y-2 text-gray-300">
                        <li><a href="#" class="hover:text-white transition-colors duration-300">Project management</a></li>
                        <li><a href="#" class="hover:text-white transition-colors duration-300">Time tracker</a></li>
                        <li><a href="#" class="hover:text-white transition-colors duration-300">Time schedule</a></li>
                        <li><a href="#" class="hover:text-white transition-colors duration-300">Lead generate</a></li>
                        <li><a href="#" class="hover:text-white transition-colors duration-300">Remote Collaboration</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-2xl md:text-3xl font-bold mb-4">SavePaws Club</h3>
                    <p class="text-gray-300 mb-4">Subscribe to our Newsletter</p>
                    <form class="flex flex-col sm:flex-col gap-2">
                        <input type="text" placeholder="Drop Your Feedback" class="bg-black flex-1 px-4 py-3 rounded-md border border-gray-700 focus:outline-none focus:ring-2 focus:ring-white text-white">
                        <button class="bg-white text-[#2D2F4A] px-4 py-3 rounded-md font-semibold hover:bg-gray-200 transition-colors duration-300">Feedback</button>
                    </form>
                </div>
            </div>
            <div class="mt-10 pt-4 flex flex-col sm:flex-row items-center justify-center text-gray-300 text-sm">
                <p class="text-xl mb-4 sm:mb-0 mx-4">Copyright &copy; 2025</p>
                <div class="flex space-x-4">
                    <a href="#"><i class="fab fa-facebook-f text-2xl hover:text-white transition-colors duration-300"></i></a>
                    <a href="#"><i class="fab fa-twitter text-2xl hover:text-white transition-colors duration-300"></i></a>
                    <a href="#"><i class="fab fa-instagram text-2xl hover:text-white transition-colors duration-300"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in text-2xl hover:text-white transition-colors duration-300"></i></a>
                </div>
            </div>
        </div>
    </footer>


    <script>
        function showMoreCards() {
            // Since all four cards are now visible by default, this function will simply hide the button.
            document.getElementById('view-more-btn').classList.add('hidden');
        }

        // Mobile menu toggle script
        document.addEventListener('DOMContentLoaded', () => {
            const menuBtn = document.getElementById('menu-btn');
            const mobileMenu = document.getElementById('mobile-menu');

            if (menuBtn && mobileMenu) {
                menuBtn.addEventListener('click', () => {
                    mobileMenu.classList.toggle('hidden');
                    mobileMenu.classList.toggle('flex');
                });
            }
        });
    </script>


    <script src="j.js"></script>
</body>

</html>