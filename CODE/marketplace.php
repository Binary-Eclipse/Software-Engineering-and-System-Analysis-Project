<?php
// config.php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "savepaws";

// Create mysqli connection (object oriented)
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// Optional: set charset
$conn->set_charset("utf8mb4");
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Pet Marketplace - SavePaws</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer"
    />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        @layer components {
            .bg-best-seller-red {
                background-color: #ef4444;
            }
            .bg-sale-green {
                background-color: #10b981;
            }
            .bg-new-yellow {
                background-color: #f59e0b;
            }
            .text-primary-indigo {
                color: #4f46e5;
            }
            .bg-primary-indigo {
                background-color: #4f46e5;
            }
            .hover\:bg-indigo-700:hover {
                background-color: #4338ca;
            }
        }
        /* Custom styles for modals and transitions */
        .modal {
            transition: opacity 0.3s ease;
        }
        .modal-content {
            transition: transform 0.3s ease;
        }
        /* Custom radio button for payment */
        .payment-option.active {
            border-color: #4f46e5;
            background-color: #eef2ff;
        }
    </style>
</head>

<body class="bg-gray-50 font-['Poppins',_sans-serif] text-gray-800 ">

    <nav class="flex flex-wrap justify-between items-center px-2 md:px-4 py-4 bg-white shadow-lg sticky top-0 z-50">
                   <h1 class="font-semibold  md:text-xl text-lg  text-sky-500 my-auto ml-5"><i class="fa-solid fa-paw text-amber-950"></i>SavePaws</h1>
        <ul class="hidden lg:flex mx-auto justify-evenly flex-wrap">
            <li><a href="gst.php" class="text-sm lg:text-sm font-bold text-black hover:text-indigo-600 lg:p-5 transform transition-transform hover:scale-120">Home</a></li>
            <li><a href="marketplace.php" class="text-sm lg:text-sm font-bold text-indigo-600 lg:p-5">Shop</a></li>
            <li><a href="clinic.php" class="text-sm lg:text-sm font-bold text-black hover:text-indigo-600 lg:p-5 transform transition-transform hover:scale-120">Clinics</a></li>
            <li><a href="rescue.php" class="text-sm lg:text-sm font-bold text-black hover:text-indigo-600 lg:p-5 transform transition-transform hover:scale-120">Rescue</a></li>
            <li><a href="blog.php" class="text-sm lg:text-sm font-bold text-black hover:text-indigo-600 lg:p-5 transform transition-transform hover:scale-120">Blog</a></li>
            <li><a href="adopt.php" class="text-sm lg:text-sm font-bold text-black hover:text-indigo-600 lg:p-5 transform transition-transform hover:scale-120">Adopt</a></li>
            <li><a href="donation.php" class="text-sm lg:text-sm font-bold text-black hover:text-indigo-600 lg:p-5 transform transition-transform hover:scale-120">Donate</a></li>
        </ul>


        <div class=" hidden lg:flex sm:hidden items-center space-x-2 lg:space-x-5 mr-5">
                <div class="relative cursor-pointer" id="cart-button">
        <i class="fas fa-shopping-cart text-2xl text-gray-600 hover:text-primary-indigo"></i>
        <span id="cart-count" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center hidden">0</span>
    </div>
            <div class="flex justify-center items-center">
                <a href="login.php" class="text-sm lg:text-sm font-bold text-black hover:text-indigo-600">Logout</a>
                
            </div>
    <div class="flex justify-center items-center space-x-2">
                <a href="profile.php?page=dashboard" class="text-xl text-black hover:text-indigo-600 transition-colors" aria-label="User Profile">
                    <i class="fa-solid fa-user-circle"></i> 
                </a>
                <a href="login.php" class="text-sm lg:text-sm font-bold text-black hover:text-indigo-600">Logout</a>
            </div>        </div>

      <button id="menu-btn" class="lg:hidden text-xl text-black mr-5">
      <i class="fa-solid fa-bars"></i>
    </button>
    </nav>

    <ul id="mobile-menu" class="hidden flex-col space-y-4 border-t-4 border-gray-500 bg-white shadow-md p-6 lg:hidden">

        <div class="flex items-center justify-evenly space-x-2 lg:space-x-5 bg-gray-200 rounded-2xl py-2">
              <div class="relative cursor-pointer" id="cart-button">
        <i class="fas fa-shopping-cart text-2xl text-gray-600 hover:text-primary-indigo"></i>
        <span id="cart-count" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center hidden">0</span>
    </div>
    <div class="flex justify-center items-center space-x-2">
                <a href="profile.php?page=dashboard" class="text-xl text-black hover:text-indigo-600 transition-colors" aria-label="User Profile">
                    <i class="fa-solid fa-user-circle"></i> 
                </a>
                <a href="login.php" class="text-sm lg:text-sm font-bold text-black hover:text-indigo-600">Logout</a>
            </div>            <div class="flex justify-center items-center">
                <a href="login.php" class="text-sm lg:text-sm font-bold text-black hover:text-indigo-600">Logout</a>
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


    <section class="relative w-full h-[50vh] bg-center bg-cover bg-no-repeat flex items-center px-4 sm:px-6 lg:px-8" style="background-image: url('img/happy rescued dog.png');">
        <div class="absolute inset-0 bg-black/40"></div>
        <div class="relative z-10 max-w-5xl flex flex-col items-start text-left py-20">
            <h1 class="font-serif text-4xl sm:text-5xl md:text-6xl text-white leading-tight mb-6 max-w-4xl">
                The Pet Marketplace
            </h1>
            <p class="text-base sm:text-lg text-white leading-relaxed mb-8 max-w-2xl">
                Quality products for your beloved pets. Every purchase supports our rescue missions.
            </p>
        </div>
    </section>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative my-10 py-5">
        <input type="text" id="search-input" placeholder="Search for toys, treats, and more..." class="rounded-xl w-full py-4 pl-8 pr-12 text-lg border-2 border-gray-300 shadow-sm focus:ring-primary-indigo focus:ring-2 focus:border-primary-indigo focus:shadow-lg transition">
        <svg class="h-6 w-6 absolute top-1/2 right-10 -translate-y-1/2 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
    </div>

    <div id="toast-container" class="fixed top-24 right-5 z-[100]"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-left font-bold text-black text-2xl mt-10">Shop By Category</div>
        <div id="category-grid" class="grid gap-4 sm:gap-6 grid-cols-2 md:grid-cols-3 lg:grid-cols-6 my-6 sm:my-10 shadow-lg p-4 sm:p-5 rounded-xl bg-white">
            <div data-category="Pet Food" class="category-filter border-gray-300 rounded-lg text-center p-4 sm:p-6 bg-white hover:scale-105 duration-300 hover:border-blue-700 border-2 transition cursor-pointer">
                <i class="fa-solid fa-bowl-food text-blue-700 text-3xl sm:text-4xl mb-2 pointer-events-none"></i>
                <h1 class="text-sm sm:text-base font-semibold pointer-events-none">Pet Food</h1>
            </div>
            <div data-category="Treats" class="category-filter border-gray-300 rounded-lg text-center p-4 sm:p-6 bg-white hover:scale-105 duration-300 hover:border-blue-700 border-2 transition cursor-pointer">
                <i class="fa-solid fa-bone text-blue-700 text-3xl sm:text-4xl mb-2 pointer-events-none"></i>
                <h1 class="text-sm sm:text-base font-semibold pointer-events-none">Treats</h1>
            </div>
            <div data-category="Medicine" class="category-filter border-gray-300 rounded-lg text-center p-4 sm:p-6 bg-white hover:scale-105 duration-300 hover:border-blue-700 border-2 transition cursor-pointer">
                <i class="fa-solid fa-pills text-blue-700 text-3xl sm:text-4xl mb-2 pointer-events-none"></i>
                <h1 class="text-sm sm:text-base font-semibold pointer-events-none">Medicine</h1>
            </div>
            <div data-category="Beds" class="category-filter border-gray-300 rounded-lg text-center p-4 sm:p-6 bg-white hover:scale-105 duration-300 hover:border-blue-700 border-2 transition cursor-pointer">
                <i class="fa-solid fa-house-chimney text-blue-700 text-3xl sm:text-4xl mb-2 pointer-events-none"></i>
                <h1 class="text-sm sm:text-base font-semibold pointer-events-none">Beds</h1>
            </div>
            <div data-category="Toys" class="category-filter border-gray-300 rounded-lg text-center p-4 sm:p-6 bg-white hover:scale-105 duration-300 hover:border-blue-700 border-2 transition cursor-pointer">
                <i class="fa-solid fa-baseball-bat-ball text-blue-700 text-3xl sm:text-4xl mb-2 pointer-events-none"></i>
                <h1 class="text-sm sm:text-base font-semibold pointer-events-none">Toys</h1>
            </div>
            <div data-category="Apparel" class="category-filter border-gray-300 rounded-lg text-center p-4 sm:p-6 bg-white hover:scale-105 duration-300 hover:border-blue-700 border-2 transition cursor-pointer">
                <i class="fa-solid fa-vest-patches text-blue-700 text-3xl sm:text-4xl mb-2 pointer-events-none"></i>
                <h1 class="text-sm sm:text-base font-semibold pointer-events-none">Apparel</h1>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 my-10">
        <div class="w-full">
            <h2 id="products-title" class="text-2xl font-bold text-gray-800 mb-2 cursor-pointer hover:text-primary-indigo">All Products</h2>
            <p class="text-gray-500 mb-6" id="product-count"></p>
        </div>
        <div id="product-grid" class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
            </div>
    </div>

    <footer class="bg-[#1A253DF0] text-white py-12 px-6 w-full mt-20">
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

    <div id="product-modal" class="modal fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-[99] hidden opacity-0">
        <div id="product-modal-content" class="modal-content bg-white rounded-xl shadow-2xl w-full max-w-4xl max-h-[90vh] overflow-y-auto transform scale-95">
        </div>
    </div>

    <div id="cart-modal" class="modal fixed inset-0 bg-black bg-opacity-50 flex justify-end z-[99] hidden opacity-0">
        <div id="cart-modal-content" class="modal-content bg-gray-100 w-full max-w-md h-full shadow-2xl transform translate-x-full flex flex-col">
        </div>
    </div>

<script>
        document.addEventListener('DOMContentLoaded', () => {
            const allProducts = [{
                id: 1,
                name: "Pedigree Dog Food",
                category: "Pet Food",
                price: 5500,
                marketPrice: 7999,
                rating: 3.5,
                reviews: 234,
                image: "img/food1.png",
                tags: ['Best Seller', '-38% OFF']
            }, {
                id: 2,
                name: "Nature Recipe Dog Food",
                category: "Pet Food",
                price: 5500,
                marketPrice: 7999,
                rating: 4.5,
                reviews: 198,
                image: "img/food2.png",
                tags: ['New', '-38% OFF']
            }, {
                id: 3,
                name: "Whiskas Cat Food",
                category: "Pet Food",
                price: 5500,
                marketPrice: 7999,
                rating: 4.0,
                reviews: 312,
                image: "img/food3.png",
                tags: ['-38% OFF']
            }, {
                id: 4,
                name: "Plush Squeaky Toy",
                category: "Toys",
                price: 800,
                marketPrice: 1200,
                rating: 4.7,
                reviews: 512,
                image: "img/food4.png", // Placeholder, replace with actual toy image
                tags: ['Best Seller']
            }, {
                id: 5,
                name: "Grain-Free Cat food",
                category: "Pet Food",
                price: 6900,
                marketPrice: 7999,
                rating: 4.8,
                reviews: 450,
                image: "img/food5.png",
                tags: ['Best Seller']
            }, {
                id: 6,
                name: "Cozy Pet Bed",
                category: "Beds",
                price: 2500,
                marketPrice: 3500,
                rating: 4.9,
                reviews: 620,
                image: "img/food6.png", // Placeholder
                tags: ['New']
            }, {
                id: 7,
                name: "Petslife Bird Food",
                category: "Pet Food",
                price: 5500,
                marketPrice: 7999,
                rating: 4.3,
                reviews: 210,
                image: "img/food7.png",
                tags: ['-38% OFF']
            }, {
                id: 8,
                name: "Flea & Tick Medicine",
                category: "Medicine",
                price: 1500,
                marketPrice: 2000,
                rating: 4.8,
                reviews: 780,
                image: "img/food8.png", // Placeholder
                tags: ['Sale']
            },
            {
                id: 9,
                name: "Chewable Dog Treats",
                category: "Treats",
                price: 950,
                marketPrice: 1300,
                rating: 4.6,
                reviews: 430,
                image: "img/food2.png", // Placeholder
                tags: ['Best Seller']
            },
             {
                id: 10,
                name: "Stylish Dog Sweater",
                category: "Apparel",
                price: 1800,
                marketPrice: 2500,
                rating: 4.7,
                reviews: 310,
                image: "img/food1.png", // Placeholder
                tags: ['New']
            }];

            let cart = [];
            let checkoutData = {
                customerName: '',
                address: '',
                email: '',
                paymentMethod: 'card'
            }; // Stores temporary checkout form data

            const productGrid = document.getElementById('product-grid');
            const productCount = document.getElementById('product-count');
            const productsTitle = document.getElementById('products-title');
            const searchInput = document.getElementById('search-input');
            const categoryGrid = document.getElementById('category-grid');
            const productModal = document.getElementById('product-modal');
            const productModalContent = document.getElementById('product-modal-content');
            const cartButton = document.getElementById('cart-button');
            const cartModal = document.getElementById('cart-modal');
            const cartModalContent = document.getElementById('cart-modal-content');
            const cartCount = document.getElementById('cart-count');

            // --- RENDER PRODUCTS ---
            const renderProducts = (productsToRender) => {
                productGrid.innerHTML = '';
                productCount.textContent = `${productsToRender.length} products found`;
                productsToRender.forEach(product => {
                    const productCard = document.createElement('div');
                    productCard.className = 'bg-white rounded-xl shadow-lg overflow-hidden transition duration-300 hover:shadow-xl group cursor-pointer';
                    productCard.dataset.productId = product.id;

                    let tagsHtml = product.tags.map((tag, index) => {
                         let bgColor = 'bg-gray-500';
                         if (tag.includes('Best Seller')) bgColor = 'bg-best-seller-red';
                         else if (tag.includes('OFF') || tag.includes('Sale')) bgColor = 'bg-sale-green';
                         else if (tag.includes('New')) bgColor = 'bg-new-yellow';
                         let position = index === 0 ? 'left-2' : 'right-2';
                         return `<span class="absolute top-2 ${position} ${bgColor} text-white text-xs font-semibold px-2 py-0.5 rounded-full shadow-md">${tag}</span>`;
                    }).join('');


                    productCard.innerHTML = `
                        <div class="relative">
                            <img src="${product.image}" alt="${product.name}" class="w-full h-48 object-cover group-hover:scale-[1.03] transition duration-300">
                            ${tagsHtml}
                        </div>
                        <div class="p-4">
                            <p class="text-xs text-gray-400 uppercase">${product.category}</p>
                            <h3 class="text-lg font-semibold text-gray-800 leading-tight mb-2 truncate">${product.name}</h3>
                            <div class="flex items-center text-sm text-yellow-500 mb-3">
                                ${getStarRating(product.rating)}
                                <span class="text-xs text-gray-500 ml-2">(${product.reviews})</span>
                            </div>
                            <p class="text-xl font-bold text-primary-indigo">৳${product.price.toLocaleString()}</p>
                            <p class="text-sm text-gray-400 line-through mb-2">৳${product.marketPrice.toLocaleString()}</p>
                        </div>
                        <div class="p-4 pt-0">
                            <button data-product-id="${product.id}" class="add-to-cart-btn w-full bg-indigo-600 text-white font-semibold py-2 rounded-lg shadow-md hover:bg-indigo-700 transition duration-150">
                                <i class="fas fa-cart-plus mr-2"></i>Add to Cart
                            </button>
                        </div>
                    `;
                    productGrid.appendChild(productCard);
                });
            };

            // --- STAR RATING ---
            const getStarRating = (rating) => {
                let stars = '';
                for (let i = 1; i <= 5; i++) {
                    if (i <= rating) stars += '<i class="fas fa-star"></i>';
                    else if (i - 0.5 <= rating) stars += '<i class="fas fa-star-half-alt"></i>';
                    else stars += '<i class="far fa-star text-gray-300"></i>';
                }
                return stars;
            };

            // --- MODAL HANDLING ---
            const openModal = (modal) => {
                modal.classList.remove('hidden');
                setTimeout(() => {
                    modal.classList.remove('opacity-0');
                    modal.querySelector('.modal-content').classList.remove('scale-95', 'translate-x-full');
                }, 10);
            };

            const closeModal = (modal) => {
                modal.classList.add('opacity-0');
                modal.querySelector('.modal-content').classList.add(modal.id === 'cart-modal' ? 'translate-x-full' : 'scale-95');
                setTimeout(() => modal.classList.add('hidden'), 300);
            };

            // --- PRODUCT MODAL ---
            const openProductModal = (productId) => {
                const product = allProducts.find(p => p.id === productId);
                const savings = product.marketPrice - product.price;
                productModalContent.innerHTML = `
                    <button class="close-modal-btn absolute top-4 right-4 text-2xl text-gray-500 hover:text-gray-800 z-10">&times;</button>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6">
                        <img src="${product.image}" alt="${product.name}" class="w-full h-full object-cover rounded-lg">
                        <div>
                            <p class="text-sm text-gray-500 uppercase">${product.category}</p>
                            <h2 class="text-3xl font-bold text-gray-900 mt-1 mb-3">${product.name}</h2>
                            <div class="flex items-center text-yellow-500 mb-4">
                                ${getStarRating(product.rating)}
                                <span class="text-sm text-gray-600 ml-2">${product.rating.toFixed(1)} stars (${product.reviews} reviews)</span>
                            </div>
                            <p class="text-gray-600 mb-6">High-quality, nutritious food for your pet. Packed with essential vitamins and minerals to keep them healthy and happy.</p>
                            <div class="bg-gray-100 p-4 rounded-lg">
                                <p class="text-3xl font-bold text-primary-indigo">৳${product.price.toLocaleString()}</p>
                                <p class="text-md text-gray-500 line-through">Market Price: ৳${product.marketPrice.toLocaleString()}</p>
                                <p class="text-lg text-sale-green font-semibold mt-1 animate-pulse">You Save: ৳${savings.toLocaleString()}</p>
                            </div>
                            <button data-product-id="${product.id}" class="add-to-cart-btn w-full mt-6 bg-indigo-600 text-white font-bold py-3 rounded-lg shadow-lg hover:bg-indigo-700 transition duration-150 text-lg">
                                <i class="fas fa-cart-plus mr-2"></i>Add to Cart
                            </button>
                        </div>
                    </div>
                `;
                openModal(productModal);
            };

            // --- CART LOGIC ---
            const addToCart = (productId) => {
                const existingItem = cart.find(item => item.id === productId);
                if (existingItem) {
                    existingItem.quantity++;
                } else {
                    const product = allProducts.find(p => p.id === productId);
                    cart.push({ ...product, quantity: 1 });
                }
                updateCart();
                showToast(`${allProducts.find(p => p.id === productId).name} added to cart!`);
            };
            
            const updateCart = () => {
                const count = cart.reduce((sum, item) => sum + item.quantity, 0);
                cartCount.textContent = count;
                cartCount.classList.toggle('hidden', count === 0);
                renderCartModal();
            };

            const calculateTotals = () => {
                let subtotal = cart.reduce((sum, item) => sum + item.price * item.quantity, 0);
                const shipping = 50;
                const total = subtotal + shipping;
                return { subtotal, shipping, total };
            };


            const renderCartModal = () => {
                if (cart.length === 0) {
                    cartModalContent.innerHTML = `
                        <div class="flex items-center justify-between p-4 border-b bg-white">
                            <h2 class="text-xl font-bold">Your Cart</h2>
                            <button class="close-modal-btn text-2xl text-gray-500 hover:text-gray-800">&times;</button>
                        </div>
                        <div class="flex-grow flex flex-col items-center justify-center text-center p-8">
                             <i class="fas fa-shopping-cart text-6xl text-gray-300 mb-4"></i>
                            <h3 class="text-2xl font-bold text-gray-800">Your cart is empty</h3>
                            <p class="text-gray-500 mt-2">Looks like you haven't added anything yet.</p>
                        </div>
                    `;
                    return;
                }

                const { subtotal, shipping, total } = calculateTotals();
                
                let itemsHtml = '';
                cart.forEach(item => {
                    itemsHtml += `
                        <div class="flex items-center gap-4 p-4 bg-white mb-2">
                            <img src="${item.image}" class="w-20 h-20 object-cover rounded-md">
                            <div class="flex-grow">
                                <p class="font-semibold">${item.name}</p>
                                <p class="text-sm text-gray-500">৳${item.price.toLocaleString()}</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <button data-product-id="${item.id}" class="quantity-change bg-gray-200 w-6 h-6 rounded-full font-bold">-</button>
                                <span>${item.quantity}</span>
                                <button data-product-id="${item.id}" class="quantity-change bg-gray-200 w-6 h-6 rounded-full font-bold">+</button>
                            </div>
                             <button data-product-id="${item.id}" class="remove-item text-red-500 hover:text-red-700 ml-2"><i class="fas fa-trash"></i></button>
                        </div>
                    `;
                });

                cartModalContent.innerHTML = `
                    <div class="flex items-center justify-between p-4 border-b bg-white">
                        <h2 class="text-xl font-bold">Your Cart</h2>
                        <button class="close-modal-btn text-2xl text-gray-500 hover:text-gray-800">&times;</button>
                    </div>
                    <div class="flex-grow overflow-y-auto p-2">${itemsHtml}</div>
                    <div class="p-4 bg-white border-t">
                        <div class="flex justify-between text-gray-700"><span>Subtotal</span><span>৳${subtotal.toLocaleString()}</span></div>
                        <div class="flex justify-between text-gray-700"><span>Shipping</span><span>৳${shipping.toLocaleString()}</span></div>
                        <div class="flex justify-between font-bold text-lg mt-2"><span>Total</span><span>৳${total.toLocaleString()}</span></div>
                        <button id="checkout-btn" class="w-full mt-4 bg-indigo-600 text-white font-bold py-3 rounded-lg shadow-lg hover:bg-indigo-700 transition">Proceed to Checkout</button>
                    </div>
                `;
            };
            
            const changeQuantity = (productId, change) => {
                const item = cart.find(item => item.id === productId);
                if (item) {
                    item.quantity += change;
                    if (item.quantity <= 0) {
                        cart = cart.filter(cartItem => cartItem.id !== productId);
                    }
                    updateCart();
                }
            };

            const renderCheckoutForm = () => {
                const { subtotal, shipping, total } = calculateTotals();
                
                 cartModalContent.innerHTML = `
                    <div id="checkout-view" class="flex flex-col h-full">
                         <div class="flex items-center p-4 border-b bg-white">
                            <button id="back-to-cart-btn" class="text-xl mr-4 hover:text-primary-indigo"><i class="fas fa-arrow-left"></i></button>
                            <h2 class="text-xl font-bold">Checkout</h2>
                        </div>
                        <div class="p-6 flex-grow overflow-y-auto">
                            <h3 class="font-semibold text-lg mb-4">Shipping Information</h3>
                            <form id="shipping-form" class="space-y-4">
                                <input type="text" id="customer-name" name="customerName" placeholder="Full Name" value="${checkoutData.customerName}" required class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-primary-indigo">
                                <input type="text" id="address" name="address" placeholder="Address" value="${checkoutData.address}" required class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-primary-indigo">
                                <input type="email" id="email" name="email" placeholder="Email" value="${checkoutData.email}" required class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-primary-indigo">
                            </form>
                            <h3 class="font-semibold text-lg mt-6 mb-4">Select Payment Method</h3>
                            <div class="grid grid-cols-3 gap-2 border border-gray-200 rounded-lg p-1 mb-6" id="payment-options">
                                <button data-method="card" class="payment-option text-center p-3 rounded-md font-semibold cursor-pointer transition ${checkoutData.paymentMethod === 'card' ? 'active' : ''}"><i class="fas fa-credit-card mr-2"></i>Card</button>
                                <button data-method="mobile" class="payment-option text-center p-3 rounded-md font-semibold cursor-pointer transition ${checkoutData.paymentMethod === 'mobile' ? 'active' : ''}"><i class="fas fa-mobile-alt mr-2"></i>Mobile</button>
                                <button data-method="bank" class="payment-option text-center p-3 rounded-md font-semibold cursor-pointer transition ${checkoutData.paymentMethod === 'bank' ? 'active' : ''}"><i class="fas fa-university mr-2"></i>Bank</button>
                            </div>

                            <div id="card-details" class="${checkoutData.paymentMethod === 'card' ? '' : 'hidden'}">
                                <input type="text" placeholder="Card Number" class="w-full p-3 border-2 rounded-lg mb-3 focus:border-indigo-500">
                                <div class="flex gap-3">
                                    <input type="text" placeholder="MM/YY" class="w-1/2 p-3 border-2 rounded-lg focus:border-indigo-500">
                                    <input type="text" placeholder="CVC" class="w-1/2 p-3 border-2 rounded-lg focus:border-indigo-500">
                                </div>
                            </div>
                            <div id="mobile-details" class="${checkoutData.paymentMethod === 'mobile' ? '' : 'hidden'} text-center">
                                <p class="mb-4">Select your mobile banking provider:</p>
                                <div class="flex justify-center gap-4">
                                     <img src="https://logowik.com/content/uploads/images/bkash-new-logo-20232152.logowik.com.webp" class="h-10 cursor-pointer border-2 border-transparent hover:border-pink-500 rounded-md">
                                     <img src="https://seeklogo.com/images/N/nagad-logo-7A7521A39C-seeklogo.com.png" class="h-10 cursor-pointer border-2 border-transparent hover:border-orange-500 rounded-md">
                                     <img src="https://www.logo.wine/a/logo/Rocket_(mobile_banking)/Rocket_(mobile_banking)-Logo.wine.svg" class="h-10 cursor-pointer border-2 border-transparent hover:border-purple-500 rounded-md">
                                </div>
                                <p class="text-sm text-gray-600 mt-4">After confirming, you will receive a request on your phone.</p>
                            </div>
                             <div id="bank-details" class="${checkoutData.paymentMethod === 'bank' ? '' : 'hidden'} text-left bg-gray-50 p-4 rounded-lg border">
                                <p class="text-gray-700 mb-3 font-semibold">Please transfer your payment to the following bank account:</p>
                                <div class="space-y-2 text-sm">
                                    <div class="flex justify-between"><span class="text-gray-500">Account Name:</span><span class="font-mono font-semibold text-gray-800">SavePaws Marketplace</span></div>
                                    <div class="flex justify-between"><span class="text-gray-500">Account No:</span><span class="font-mono font-semibold text-gray-800">0987654321</span></div>
                                    <div class="flex justify-between"><span class="text-gray-500">Bank Name:</span><span class="font-mono font-semibold text-gray-800">Commerce Bank for Pets</span></div>
                                </div>
                            </div>
                        </div>
                         <div class="p-4 bg-white border-t">
                             <div class="flex justify-between font-bold text-xl mb-3"><span>Total Payable</span><span>৳${total.toLocaleString()}</span></div>
                            <button id="pay-now-btn" class="w-full bg-indigo-600 text-white font-bold py-3 rounded-lg shadow-lg hover:bg-indigo-700 transition">Pay Now</button>
                        </div>
                    </div>
                 `;
            };
            
            const handleCheckoutSubmission = async () => {
                const form = document.getElementById('shipping-form');
                const nameInput = document.getElementById('customer-name');
                const addressInput = document.getElementById('address');
                const emailInput = document.getElementById('email');
                const payNowBtn = document.getElementById('pay-now-btn');

                // 1. Client-side Validation
                if (!form.checkValidity()) {
                    form.reportValidity();
                    return;
                }
                
                payNowBtn.textContent = 'Processing...';
                payNowBtn.disabled = true;

                const { subtotal, shipping, total } = calculateTotals();
                
                // 2. Prepare Data Structure for PHP
                const orderData = {
                    customer_name: nameInput.value,
                    shipping_address: addressInput.value,
                    customer_email: emailInput.value,
                    payment_method: checkoutData.paymentMethod,
                    total_amount: total,
                    shipping_cost: shipping,
                    items: cart.map(item => ({
                        product_id: item.id,
                        product_name: item.name,
                        unit_price: item.price,
                        quantity: item.quantity
                    }))
                };

                // 3. Send to Server via AJAX
                try {
                    const response = await fetch('handle_checkout.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(orderData)
                    });

                    // We MUST await the JSON parsing to see the result
                    const result = await response.json();
                    
                    if (result.success) {
                        // SUCCESS PATH: Show confirmation message and reset cart
                        renderConfirmation(result.order_id);
                        showToast(`Order #${result.order_id} placed successfully!`);
                    } else {
                        // FAILURE PATH: Database reported an error (clean JSON output)
                        alert(`Checkout failed: ${result.message}`);
                    }

                } catch (error) {
                    // CATCH PATH: Network or malformed JSON error (server crash or bad output)
                    console.error('Checkout Submission Error:', error);
                    alert('Could not complete order. Please check server connection.');
                } finally {
                    payNowBtn.textContent = 'Pay Now';
                    payNowBtn.disabled = false;
                }
            };


            const renderConfirmation = (orderId) => {
                 cartModalContent.innerHTML = `
                     <div class="flex flex-col h-full items-center justify-center text-center p-8">
                         <i class="fas fa-check-circle text-6xl text-green-500 mb-4"></i>
                         <h2 class="text-2xl font-bold">Payment Successful!</h2>
                         <p class="text-gray-600 mt-2">Thank you for your purchase. Your order #${orderId} is being processed.</p>
                         <button id="close-confirmation-btn" class="mt-8 bg-indigo-600 text-white font-semibold py-2 px-6 rounded-lg shadow-md hover:bg-indigo-700 transition">Close</button>
                     </div>
                 `;
                // --- CRITICAL: CLEAR CART DATA AND UPDATE UI ---
                cart = [];
                updateCart(); 
            };

            // --- TOAST NOTIFICATION ---
            const showToast = (message) => {
                const toastContainer = document.getElementById('toast-container');
                const toast = document.createElement('div');
                toast.className = 'bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg mb-2 animate-pulse';
                toast.textContent = message;
                toastContainer.appendChild(toast);
                setTimeout(() => {
                    toast.remove();
                }, 3000);
            };

            // --- FILTERING LOGIC ---
            const filterAndRender = () => {
                const searchTerm = searchInput.value.toLowerCase();
                const activeCategory = document.querySelector('.category-filter.active')?.dataset.category;

                let filteredProducts = allProducts;

                if (activeCategory) {
                    filteredProducts = filteredProducts.filter(p => p.category === activeCategory);
                }

                if (searchTerm) {
                    filteredProducts = filteredProducts.filter(p => p.name.toLowerCase().includes(searchTerm));
                }
                
                renderProducts(filteredProducts);
            };

            // --- EVENT LISTENERS ---
            productGrid.addEventListener('click', (e) => {
                if (e.target.closest('.add-to-cart-btn')) {
                    const productId = parseInt(e.target.closest('.add-to-cart-btn').dataset.productId);
                    addToCart(productId);
                } else {
                    const card = e.target.closest('.group');
                    if (card) {
                        const productId = parseInt(card.dataset.productId);
                        openProductModal(productId);
                    }
                }
            });

            productModal.addEventListener('click', (e) => {
                if (e.target === productModal || e.target.closest('.close-modal-btn')) {
                    closeModal(productModal);
                } else if (e.target.closest('.add-to-cart-btn')) {
                    const productId = parseInt(e.target.closest('.add-to-cart-btn').dataset.productId);
                    addToCart(productId);
                    closeModal(productModal);
                }
            });

            cartButton.addEventListener('click', () => openModal(cartModal));

            cartModal.addEventListener('click', (e) => {
                if (e.target.closest('.close-modal-btn')) {
                    closeModal(cartModal);
                } else if (e.target.closest('.quantity-change')) {
                    const productId = parseInt(e.target.closest('.quantity-change').dataset.productId);
                    const change = e.target.closest('.quantity-change').textContent === '+' ? 1 : -1;
                    changeQuantity(productId, change);
                } else if(e.target.closest('.remove-item')){
                    const productId = parseInt(e.target.closest('.remove-item').dataset.productId);
                    cart = cart.filter(item => item.id !== productId);
                    updateCart();
                } else if(e.target.closest('#checkout-btn')) {
                    renderCheckoutForm();
                } else if (e.target.closest('#back-to-cart-btn')) {
                    renderCartModal();
                } else if (e.target.closest('#pay-now-btn')) {
                    handleCheckoutSubmission(); // <--- AJAX SUBMISSION
                } else if (e.target.closest('#close-confirmation-btn')) {
                    closeModal(cartModal);
                }
                
                // Payment Method Selector
                if (e.target.closest('#payment-options')) { 
                    const paymentOptionsDiv = e.target.closest('#payment-options');
                    const paymentOptionBtn = e.target.closest('.payment-option');
                    
                    if (paymentOptionBtn) {
                        const method = paymentOptionBtn.dataset.method;
                        // Update UI
                        paymentOptionsDiv.querySelectorAll('.payment-option').forEach(opt => opt.classList.remove('active'));
                        paymentOptionBtn.classList.add('active');
                        // Update Data
                        checkoutData.paymentMethod = method;
                        // Show/Hide details
                        ['card-details', 'mobile-details', 'bank-details'].forEach(id => document.getElementById(id)?.classList.add('hidden'));
                        document.getElementById(`${method}-details`)?.classList.remove('hidden');
                    }
                }
            });
            
            // Event listener for updating checkoutData as user types
            cartModal.addEventListener('input', (e) => {
                if (e.target.id === 'customer-name') checkoutData.customerName = e.target.value;
                if (e.target.id === 'address') checkoutData.address = e.target.value;
                if (e.target.id === 'email') checkoutData.email = e.target.value;
            });


            searchInput.addEventListener('input', filterAndRender);
            
            categoryGrid.addEventListener('click', (e) => {
                const categoryCard = e.target.closest('.category-filter');
                if(categoryCard) {
                    const category = categoryCard.dataset.category;
                    const isActive = categoryCard.classList.contains('active');

                    document.querySelectorAll('.category-filter').forEach(c => c.classList.remove('active', 'border-blue-700'));
                    
                    if (!isActive) {
                        categoryCard.classList.add('active', 'border-blue-700');
                        productsTitle.textContent = `${category}`;
                    } else {
                        productsTitle.textContent = 'All Products';
                    }
                    filterAndRender();
                }
            });

            productsTitle.addEventListener('click', () => {
                document.querySelectorAll('.category-filter').forEach(c => c.classList.remove('active', 'border-blue-700'));
                productsTitle.textContent = 'All Products';
                searchInput.value = '';
                filterAndRender();
            });

            const menuBtn = document.getElementById('menu-btn');
            const mobileMenu = document.getElementById('mobile-menu');
            menuBtn.addEventListener('click', () => mobileMenu.classList.toggle('hidden'));
            
            // Initial Render
            updateCart();
            renderProducts(allProducts);
        });
    </script>
   


<script src="j.js"></script>
</body>

</html>