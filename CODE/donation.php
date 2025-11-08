<?php
// donation.php - Handles display of the form
session_start();
include_once "config.php";
// No processing logic here; it's all moved to the AJAX handler
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donate to SavePaws - Be a Hero for Animals</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer"
    />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
     
        .no-spinner::-webkit-outer-spin-button,
        .no-spinner::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        .no-spinner {
            -moz-appearance: textfield;
        }
        .payment-option.active {
            border-color: #4f46e5;
            background-color: #eef2ff;
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


        <div class=" hidden lg:flex  sm:hidden items-center space-x-2 lg:space-x-5 mr-5">
        
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

          <div class="  flex items-center justify-evenly space-x-2 lg:space-x-5 bg-gray-200 rounded-2xl py-2">
                      <div class="rounded-full bg-slate-300 shadow-md w-20 h-20 lg:w-12 lg:h-12 flex items-center justify-center text-sm lg:text-base">Img</div>

        
            <div class="flex justify-center items-center">
                <a href="login.php" class="text-sm lg:text-sm font-bold text-black hover:text-indigo-600">Logout</a>            </div>
        </div>

        <li><a href="gst.php" class="text-lg font-bold text-black hover:text-indigo-600">Home</a></li>
        <li><a href="marketplace.php" class="text-lg font-bold text-black hover:text-indigo-600">Shop</a></li>
        <li><a href="clinic.php" class="text-lg font-bold text-black hover:text-indigo-600">Clinics</a></li>
        <li><a href="rescue.php" class="text-lg font-bold text-black hover:text-indigo-600">Resque Team</a></li>
        <li><a href="blog.php" class="text-lg font-bold text-black hover:text-indigo-600">Blog</a></li>
        <li><a href="adopt.php" class="text-lg font-bold text-black hover:text-indigo-600">Adopt</a></li>
        <li><a href="donation.php" class="text-lg font-bold text-black hover:text-indigo-600">Donate</a></li>
    </ul>

    <section class="relative bg-cover bg-center bg-no-repeat min-h-[60vh] flex items-center justify-center px-4" style="background-image: url('img/donate and save.png');">
        <div class="absolute inset-0 bg-black/50"></div>
        <div class="relative text-center z-10">
            <h1 class="font-serif text-4xl sm:text-5xl md:text-7xl font-bold leading-tight mb-4 text-white">Donate & Save Souls</h1>
            <p class="text-lg md:text-2xl text-gray-200 max-w-2xl">See the face of hope. Your donation makes their tail wag.</p>
        </div>
    </section>

    <section class="container mx-auto px-6 py-16">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
            <div class="p-8">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-6">How Your Donation Helps</h2>
                <p class="text-gray-600 mb-8">Every contribution, big or small, fuels our mission to rescue, heal, and rehome animals in need. Here’s how your generosity makes a direct impact:</p>
                <div class="space-y-6">
                    <div class="flex items-center gap-6 p-6 bg-white rounded-xl shadow-md border border-gray-100">
                        <div class="flex-shrink-0 w-20 h-20 rounded-full bg-indigo-100 flex items-center justify-center"><i class="fa-solid fa-notes-medical text-3xl text-indigo-600"></i></div>
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900">70% on Medical Care</h3>
                            <p class="text-gray-600">Funds emergency vet visits, vaccinations, spay/neuter surgeries, and ongoing medical treatments.</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-6 p-6 bg-white rounded-xl shadow-md border border-gray-100">
                        <div class="flex-shrink-0 w-20 h-20 rounded-full bg-green-100 flex items-center justify-center"><i class="fa-solid fa-house-chimney-medical text-3xl text-green-600"></i></div>
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900">20% on Shelter & Care</h3>
                            <p class="text-gray-600">Covers safe shelter, bedding, and enrichment to keep animals comfortable and happy while they wait for a home.</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-6 p-6 bg-white rounded-xl shadow-md border border-gray-100">
                        <div class="flex-shrink-0 w-20 h-20 rounded-full bg-yellow-100 flex items-center justify-center"><i class="fa-solid fa-bowl-food text-3xl text-yellow-600"></i></div>
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900">10% on Food & Supplies</h3>
                            <p class="text-gray-600">Provides nutritious food and essential supplies for hundreds of animals in our care.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-xl border border-gray-200 p-6 md:p-10 sticky top-28">
                <form id="donationForm" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-800 text-center mb-2">Make a Donation</h2>
                    <p class="text-center text-gray-500 mb-6">Your generosity saves lives.</p>
                    <div class="mb-6">
                        <label class="text-lg font-semibold text-gray-700">Choose an Amount</label>
                        <div class="grid grid-cols-3 gap-3 mt-2">
                            <label class="relative"><input type="radio" name="amount" value="100" class="sr-only peer" onclick="fillAmount(this.value)"><span class="block text-center p-4 rounded-lg border-2 border-gray-200 peer-checked:border-indigo-600 peer-checked:bg-indigo-50 peer-checked:text-indigo-800 font-bold cursor-pointer transition">৳100</span></label>
                            <label class="relative"><input type="radio" name="amount" value="500" class="sr-only peer" onclick="fillAmount(this.value)"><span class="block text-center p-4 rounded-lg border-2 border-gray-200 peer-checked:border-indigo-600 peer-checked:bg-indigo-50 peer-checked:text-indigo-800 font-bold cursor-pointer transition">৳500</span></label>
                            <label class="relative"><input type="radio" name="amount" value="1000" class="sr-only peer" onclick="fillAmount(this.value)"><span class="block text-center p-4 rounded-lg border-2 border-gray-200 peer-checked:border-indigo-600 peer-checked:bg-indigo-50 peer-checked:text-indigo-800 font-bold cursor-pointer transition">৳1000</span></label>
                        </div>
                    </div>
                    <div>
                        <label for="custom_amount" class="text-lg font-semibold text-gray-700">Or Enter a Custom Amount</label>
                        <div class="relative mt-2">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 font-bold">৳</span>
                            <input type="number" id="t_field" name="custom_amount" placeholder="50" class="no-spinner w-full pl-8 pr-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-lg">
                        </div>
                    </div>
                    <div class="mt-6">
                        <label class="text-lg font-semibold text-gray-700">Donation Type</label>
                        <div class="mt-2 grid grid-cols-2 gap-3 p-1 bg-gray-100 rounded-lg">
                            <label><input type="radio" name="type" value="One Time" class="sr-only peer" required><span class="block text-center p-2 rounded-md peer-checked:bg-white peer-checked:shadow font-semibold cursor-pointer transition">One Time</span></label>
                            <label><input type="radio" name="type" value="Monthly" class="sr-only peer" required><span class="block text-center p-2 rounded-md peer-checked:bg-white peer-checked:shadow font-semibold cursor-pointer transition">Monthly</span></label>
                        </div>
                    </div>
                    <div class="mt-6">
                        <label for="reason" class="text-lg font-semibold text-gray-700">Add a Comment (Optional)</label>
                        <textarea id="reason" name="reason" placeholder="Support a specific cause or rescue..." class="w-full mt-2 p-3 border-2 border-gray-300 bg-white rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                    </div>
                    <button type="submit" title="Accepts Bkash, Nagad, Rocket, Visa, Mastercard" class="w-full mt-8 py-4 bg-yellow-400 hover:bg-yellow-500 text-gray-900 font-bold text-lg rounded-xl shadow-md transition-transform transform hover:scale-105">Donate Now</button>
                </form>
            </div>
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

    <div id="payment-modal" class="fixed inset-0 bg-black/70 flex items-center justify-center p-4 z-[99] hidden">
        <div id="payment-content" class="bg-white rounded-xl shadow-2xl w-full max-w-lg transition-transform transform scale-95">
            </div>
    </div>
    
    <div id="toast-container" class="fixed top-24 right-5 z-[100]"></div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const menuBtn = document.getElementById('menu-btn');
            const mobileMenu = document.getElementById('mobile-menu');
            const donationForm = document.getElementById('donationForm');
            const paymentModal = document.getElementById('payment-modal');
            const paymentContent = document.getElementById('payment-content');

            if (menuBtn && mobileMenu) {
                menuBtn.addEventListener('click', () => {
                    mobileMenu.classList.toggle('hidden');
                });
            }
            
            const showToast = (message, isError = false) => {
                const toastContainer = document.getElementById('toast-container');
                const toast = document.createElement('div');
                toast.className = `${isError ? 'bg-red-500' : 'bg-green-500'} text-white px-4 py-2 rounded-lg shadow-lg mb-2`;
                toast.textContent = message;
                toastContainer.appendChild(toast);
                setTimeout(() => {
                    toast.remove();
                }, 3000);
            };

            const openModal = () => {
                paymentModal.classList.remove('hidden');
                setTimeout(() => paymentContent.classList.remove('scale-95'), 10);
            };

            const closeModal = () => {
                paymentContent.classList.add('scale-95');
                setTimeout(() => paymentModal.classList.add('hidden'), 300);
            };

            const renderPaymentView = (amount) => {
                paymentContent.innerHTML = `
                    <div id="payment-view">
                        <div class="flex justify-between items-center p-6 border-b">
                            <h2 class="text-2xl font-bold">Complete Your Donation</h2>
                            <button id="close-modal-btn" class="text-2xl text-gray-500 hover:text-gray-800">&times;</button>
                        </div>
                        <div class="p-6">
                            <p class="text-center text-lg mb-6">You are donating <span class="font-bold text-indigo-600 text-2xl">৳${amount}</span></p>
                            
                            <h3 class="font-semibold text-lg mb-3 text-gray-700">Select Your Payment Method</h3>
                            <div class="grid grid-cols-3 gap-2 border border-gray-200 rounded-lg p-1 mb-6">
                                <button data-method="card" class="payment-option text-center p-3 rounded-md font-semibold cursor-pointer transition active"><i class="fas fa-credit-card mr-2"></i>Card</button>
                                <button data-method="mobile" class="payment-option text-center p-3 rounded-md font-semibold cursor-pointer transition"><i class="fas fa-mobile-alt mr-2"></i>Mobile</button>
                                <button data-method="bank" class="payment-option text-center p-3 rounded-md font-semibold cursor-pointer transition"><i class="fas fa-university mr-2"></i>Bank</button>
                            </div>

                            <div id="card-details">
                                <input type="text" placeholder="Card Number" class="w-full p-3 border-2 rounded-lg mb-3 focus:border-indigo-500">
                                <input type="text" placeholder="Cardholder Name" class="w-full p-3 border-2 rounded-lg mb-3 focus:border-indigo-500">
                                <div class="flex gap-3">
                                    <input type="text" placeholder="MM/YY" class="w-1/2 p-3 border-2 rounded-lg focus:border-indigo-500">
                                    <input type="text" placeholder="CVC" class="w-1/2 p-3 border-2 rounded-lg focus:border-indigo-500">
                                </div>
                            </div>
                            <div id="mobile-details" class="hidden text-center">
                                <p class="mb-4">Select your mobile banking provider:</p>
                                <div class="flex justify-center gap-4">
                                     <img src="https://logowik.com/content/uploads/images/bkash-new-logo-20232152.logowik.com.webp" class="h-10 cursor-pointer border-2 border-transparent hover:border-pink-500 rounded-md">
                                     <img src="https://seeklogo.com/images/N/nagad-logo-7A7521A39C-seeklogo.com.png" class="h-10 cursor-pointer border-2 border-transparent hover:border-orange-500 rounded-md">
                                     <img src="https://www.logo.wine/a/logo/Rocket_(mobile_banking)/Rocket_(mobile_banking)-Logo.wine.svg" class="h-10 cursor-pointer border-2 border-transparent hover:border-purple-500 rounded-md">
                                </div>
                                <p class="text-sm text-gray-600 mt-4">After confirming, you will receive a request on your phone.</p>
                            </div>
                            <div id="bank-details" class="hidden text-left bg-gray-50 p-4 rounded-lg border">
                                <p class="text-gray-700 mb-3 font-semibold">Please transfer your donation to the following bank account:</p>
                                <div class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-gray-500">Account Name:</span>
                                        <span class="font-mono font-semibold text-gray-800">SavePaws Foundation</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-500">Account Number:</span>
                                        <span class="font-mono font-semibold text-gray-800">123-456-789012</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-500">Bank Name:</span>
                                        <span class="font-mono font-semibold text-gray-800">Animal Welfare Bank</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-500">Routing Number:</span>
                                        <span class="font-mono font-semibold text-gray-800">987654321</span>
                                    </div>
                                </div>
                            </div>

                            <button id="confirm-payment-btn" class="w-full mt-6 py-3 bg-yellow-400 hover:bg-yellow-500 text-gray-900 font-bold text-lg rounded-xl shadow-md transition">Confirm Payment</button>
                        </div>
                    </div>
                `;
            };

            const renderThankYouView = () => {
                 paymentContent.innerHTML = `
                    <div class="text-center p-10">
                        <i class="fas fa-check-circle text-6xl text-green-500 mb-4"></i>
                        <h2 class="text-3xl font-bold">Thank You!</h2>
                        <p class="text-gray-600 mt-2">Your generous donation will make a huge difference in an animal's life.</p>
                        <button id="done-btn" class="mt-8 bg-indigo-600 text-white font-semibold py-2 px-6 rounded-lg shadow-md hover:bg-indigo-700 transition">Done</button>
                    </div>
                 `;
            };

            // MODIFICATION: The PHP logic handles form submission, so we only use the JS listener to trigger the payment modal flow.
            donationForm.addEventListener('submit', (e) => {
                // Prevent default submission to show the payment modal
                e.preventDefault(); 
                
                const amountRadio = document.querySelector('input[name="amount"]:checked');
                const customAmountField = document.getElementById('t_field');
                const typeRadio = document.querySelector('input[name="type"]:checked');

                const amountValue = amountRadio ? amountRadio.value : customAmountField.value;

                if (!amountValue || parseFloat(amountValue) <= 0 || !typeRadio) {
                    showToast('Please enter a valid donation amount and select a donation type.', true);
                    return;
                }
                
                // If validation passes, show the modal
                renderPaymentView(amountValue);
                openModal();
                
                // Instead of submitting to PHP here, the final step in the modal will now simulate a payment and submit to PHP.
            });
            
            paymentModal.addEventListener('click', (e) => {
                if (e.target === paymentModal || e.target.closest('#close-modal-btn') || e.target.closest('#done-btn')) {
                    closeModal();
                }
                
                if (e.target.closest('.payment-option')) {
                    const method = e.target.closest('.payment-option').dataset.method;
                    document.querySelectorAll('.payment-option').forEach(opt => opt.classList.remove('active'));
                    e.target.closest('.payment-option').classList.add('active');

                    document.getElementById('card-details').classList.add('hidden');
                    document.getElementById('mobile-details').classList.add('hidden');
                    document.getElementById('bank-details').classList.add('hidden');
                    
                    document.getElementById(`${method}-details`).classList.remove('hidden');
                }
                
                if (e.target.closest('#confirm-payment-btn')) { 
                    // 1. Show the Thank You message
                    renderThankYouView();
                    
                    // 2. Submit the form to PHP after a brief delay
                    setTimeout(() => {
                        donationForm.submit();
                    }, 500); // 500ms delay to ensure the user sees the confirmation screen
                }
            });
        });

        function fillAmount(amount) {
            document.getElementById('t_field').value = amount;
        }
    </script>

</body>

</html>