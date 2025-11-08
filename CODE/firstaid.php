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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Get First Aid Guidance</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        /* Define custom colors */
        .bg-custom-purple { background-color: #6c5ce7; }
        .text-custom-purple { color: #6c5ce7; }
        .bg-custom-blue { background-color: #4a69bd; }
        .text-custom-blue { color: #4a69bd; }
        
        /* Custom styles for select arrow */
        .custom-select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='%236c5ce7'%3E%3Cpath fill-rule='evenodd' d='M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z' clip-rule='evenodd' /%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 1.5em 1.5em;
            padding-right: 2.5rem;
        }
        
        /* Custom Checkbox Styling */
        .custom-checkbox-input {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }

        .custom-checkbox-label {
            position: relative;
            padding-left: 1.75rem;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            user-select: none;
        }

        .custom-checkbox-label::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 1rem;
            height: 1rem;
            border: 2px solid #ccc;
            border-radius: 0.25rem;
            background-color: white;
            transition: all 0.2s ease;
        }

        .custom-checkbox-input:checked + .custom-checkbox-label::before {
            background-color: #6c5ce7;
            border-color: #6c5ce7;
        }

        .custom-checkbox-input:checked + .custom-checkbox-label::after {
            content: '';
            position: absolute;
            left: 0.35rem;
            top: 50%;
            transform: translateY(-50%) rotate(45deg);
            width: 0.3rem;
            height: 0.6rem;
            border: solid white;
            border-width: 0 2px 2px 0;
        }
        
        /* Modal styles */
        .modal {
            transition: opacity 0.3s ease;
        }
        .modal-content {
            transition: transform 0.3s ease;
        }

        .file-list {
            max-height: 80px;
            overflow-y: auto;
            margin-top: 5px;
            font-size: 0.8rem;
            text-align: left;
            padding-left: 10px;
        }
    </style>
</head>
<body class="bg-gray-50"> <div class="bg-red-500 text-white p-4 text-center text-lg font-bold">
        24/7 Emergency Hotline: 1-888-PET-HELP (1-888-738-4357)
    </div>

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
                <a href="login.php" class="text-sm lg:text-sm font-bold text-black hover:text-indigo-600">Login/</a>
                <a href="signup.php" class="text-sm lg:text-sm font-bold text-black hover:text-indigo-600">Signup</a>
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


    <div class="text-center mt-8 text-gray-700">
        <p class="text-lg font-semibold">Get immediate first aid guidance for your pet's emergency</p>
    </div>

    <section class="container mx-auto px-4 py-8">
        <div class="max-w-3xl mx-auto space-y-8">
            
            <div class="bg-yellow-100 text-yellow-800 p-4 rounded-lg border border-yellow-200">
                <p class="font-bold mb-2">Important:</p>
                <p class="text-sm">This tool provides general first aid guidance only. For serious injuries or life-threatening emergencies, contact your veterinarian or emergency animal hospital immediately</p>
            </div>

            <form id="first-aid-form" class="space-y-6">
                <div class="bg-white p-6 rounded-lg shadow border border-gray-100">
                    <h3 class="flex items-center text-lg font-semibold text-gray-800 mb-4">
                        <svg class="w-6 h-6 mr-2 text-custom-purple" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.618a1 1 0 010 1.414l-4.242 4.242a1 1 0 01-1.414 0L9.172 10.586a1 1 0 010-1.414l4.242-4.242a1 1 0 011.414 0z"></path></svg>
                        Pet Information
                    </h3>
                    <p class="text-gray-500 text-sm mb-4">Tell us about your pet</p>
                    <div class="space-y-4">
                        <div>
                            <label for="pet_type" class="block text-gray-700 font-medium mb-1">Pet Type *</label>
                            <select id="pet_type" name="pet_type" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-custom-purple focus:border-custom-purple custom-select" required>
                                <option value="">Select pet type</option>
                                <option value="Dog">Dog</option>
                                <option value="Cat">Cat</option>
                                <option value="Bird">Bird</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div>
                            <label for="pet_name" class="block text-gray-700 font-medium mb-1">Pet Name</label>
                            <input type="text" id="pet_name" name="pet_name" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-custom-purple focus:border-custom-purple" placeholder="Enter your pet's name">
                        </div>
                        <div>
                            <label for="urgency_level" class="block text-gray-700 font-medium mb-1">Urgency Level *</label>
                            <select id="urgency_level" name="urgency_level" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-custom-purple focus:border-custom-purple custom-select" required>
                                <option value="">Select urgency</option>
                                <option value="Critical">Critical - Life Threatening</option>
                                <option value="Urgent">Urgent - Needs immediate care</option>
                                <option value="Moderate">Moderate - Concerning but stable</option>
                                <option value="Minor">Minor - Not urgent</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow border border-gray-100">
                    <h3 class="flex items-center text-lg font-semibold text-gray-800 mb-4">
                        <svg class="w-6 h-6 mr-2 text-custom-purple" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Owner Information
                    </h3>
                    <p class="text-gray-500 text-sm mb-4">Your contact details</p>
                    <div class="space-y-4">
                        <div>
                            <label for="full_name" class="block text-gray-700 font-medium mb-1">Full Name *</label>
                            <input type="text" id="full_name" name="owner_full_name" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-custom-purple focus:border-custom-purple" placeholder="Enter your name" required>
                        </div>
                        <div>
                            <label for="phone_number" class="block text-gray-700 font-medium mb-1">Phone Number *</label>
                            <input type="tel" id="phone_number" name="owner_phone_number" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-custom-purple focus:border-custom-purple" placeholder="(555) 123-4567" required>
                        </div>
                        <div>
                            <label for="email_address" class="block text-gray-700 font-medium mb-1">Email Address</label>
                            <input type="email" id="email_address" name="owner_email" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-custom-purple focus:border-custom-purple" placeholder="your@email.com">
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow border border-gray-100">
                    <h3 class="flex items-center text-lg font-semibold text-gray-800 mb-4">
                        <svg class="w-6 h-6 mr-2 text-custom-purple" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        Emergency Situation
                    </h3>
                    <p class="text-gray-500 text-sm mb-4">Describe what happened and current symptoms</p>
                    
                    <div>
                        <label for="describe_situation" class="block text-gray-700 font-medium mb-1">Describe the Situation *</label>
                        <textarea id="describe_situation" name="situation_description" rows="4" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-custom-purple focus:border-custom-purple" placeholder="Describe what happened, when it occurred, and your pet's current condition..." required></textarea>
                    </div>

                    <div class="mt-6 mb-4">
                        <label class="block text-gray-700 font-medium mb-3">Observable Symptoms (Check all that apply)</label>
                        <div id="symptoms-container" class="grid grid-cols-2 sm:grid-cols-3 gap-4 text-sm text-gray-800">
                            <div class="flex items-center">
                                <input type="checkbox" id="bleeding" name="symptoms[]" value="Bleeding" class="custom-checkbox-input">
                                <label for="bleeding" class="custom-checkbox-label">Bleeding</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" id="seizures" name="symptoms[]" value="Seizures" class="custom-checkbox-input">
                                <label for="seizures" class="custom-checkbox-label">Seizures</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" id="difficulty_breathing" name="symptoms[]" value="Difficulty Breathing" class="custom-checkbox-input">
                                <label for="difficulty_breathing" class="custom-checkbox-label">Difficulty breathing</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" id="loss_of_consciousness" name="symptoms[]" value="Loss of Consciousness" class="custom-checkbox-input">
                                <label for="loss_of_consciousness" class="custom-checkbox-label">Loss of consciousness</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" id="vomiting" name="symptoms[]" value="Vomiting" class="custom-checkbox-input">
                                <label for="vomiting" class="custom-checkbox-label">Vomiting</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" id="swelling" name="symptoms[]" value="Swelling" class="custom-checkbox-input">
                                <label for="swelling" class="custom-checkbox-label">Swelling</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" id="limping" name="symptoms[]" value="Limping" class="custom-checkbox-input">
                                <label for="limping" class="custom-checkbox-label">Limping</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" id="pain_distress" name="symptoms[]" value="Pain/Distress" class="custom-checkbox-input">
                                <label for="pain_distress" class="custom-checkbox-label">Pain/Distress</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow border border-gray-100">
                    <h3 class="flex items-center text-lg font-semibold text-gray-800 mb-4">
                        <svg class="w-6 h-6 mr-2 text-custom-purple" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                        Injury Photo (Optional)
                    </h3>
                    <p class="text-gray-500 text-sm mb-4">
                        Upload clear photos of the injured area if possible (Max 10MB per file)
                    </p>

                    <div id="upload-box" class="flex flex-col justify-center items-center h-48 border-2 border-dashed border-gray-300 rounded-lg p-6 text-center">
                        <label for="file_upload" class="cursor-pointer text-gray-600">
                            <input type="file" id="file_upload" name="injury_photo[]" class="hidden" accept="image/png, image/jpeg, image/jpg" multiple>
                            
                            <svg id="upload-icon" class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 0115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v8"></path></svg>
                            
                            <span id="upload-main-text" class="block text-custom-purple font-medium">Click to upload image(s)</span>
                            <span id="upload-hint-text" class="block text-xs text-gray-500">PNG, JPG up to 10MB</span>

                            <div id="file-list" class="file-list hidden"></div>
                        </label>
                    </div>
                </div>

                <button type="submit" id="submit-btn" class="w-full bg-custom-blue text-white py-3 rounded-xl font-medium shadow-md hover:bg-custom-purple transition duration-300 mt-8">
                    Get First Aid Guidance
                </button>
            </form>
        </div>
    </section>
    
    <div id="guidance-modal" class="modal fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center p-4 z-50 opacity-0 pointer-events-none">
        <div id="modal-content" class="modal-content bg-white rounded-xl shadow-2xl w-full max-w-lg transform scale-95">
            <div id="modal-body" class="p-6">
                </div>
            <div class="p-4 border-t text-right">
                <button id="close-modal-btn" class="py-2 px-4 bg-custom-purple text-white rounded-lg hover:bg-custom-blue">Close</button>
            </div>
        </div>
    </div>


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
          <input 
            type="text" 
            placeholder="Drop Your Feedback" 
            class="bg-black flex-1 px-4 py-3 rounded-md border border-gray-600 focus:outline-none focus:ring-2 focus:ring-white text-white placeholder-gray-400"
          >
          <button 
            type="submit" 
            class="bg-white text-[#1A253D] px-4 py-3 rounded-md font-semibold hover:bg-gray-200 transition-colors"
          >
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const menuBtn = document.getElementById('menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        if (menuBtn) {
             menuBtn.addEventListener('click', () => mobileMenu.classList.toggle('hidden'));
        }

        const form = document.getElementById('first-aid-form');
        const submitBtn = document.getElementById('submit-btn');
        const modal = document.getElementById('guidance-modal');
        const modalBody = document.getElementById('modal-body');
        const closeModalBtn = document.getElementById('close-modal-btn');
        
        // File Upload Elements
        const fileUploadInput = document.getElementById('file_upload');
        const uploadMainText = document.getElementById('upload-main-text');
        const uploadHintText = document.getElementById('upload-hint-text');
        const fileListContainer = document.getElementById('file-list');
        const uploadIcon = document.getElementById('upload-icon');


        // --- Display File Name(s) in Upload Box ---
        if (fileUploadInput) {
            fileUploadInput.addEventListener('change', function() {
                if (this.files && this.files.length > 0) {
                    const fileCount = this.files.length;
                    
                    // 1. Update main text
                    uploadMainText.textContent = `${fileCount} File(s) Selected`;
                    
                    // 2. Change hint and icon color
                    uploadHintText.textContent = 'Ready to submit.';
                    uploadIcon.classList.remove('text-gray-400');
                    uploadIcon.classList.add('text-custom-purple');

                    // 3. Clear and populate file list container
                    fileListContainer.innerHTML = '';
                    for(let i = 0; i < fileCount; i++) {
                        const file = this.files[i];
                        const listItem = document.createElement('div');
                        listItem.textContent = `• ${file.name}`;
                        listItem.className = 'truncate text-gray-700';
                        fileListContainer.appendChild(listItem);
                    }
                    fileListContainer.classList.remove('hidden');

                } else {
                    // Reset the text if the selection is canceled
                    uploadMainText.textContent = 'Click to upload image(s)';
                    uploadHintText.textContent = 'PNG, JPG up to 10MB';
                    uploadIcon.classList.add('text-gray-400');
                    uploadIcon.classList.remove('text-custom-purple');
                    fileListContainer.classList.add('hidden');
                    fileListContainer.innerHTML = '';
                }
            });
        }
        // --- END FILE DISPLAY CODE ---


        // Modal functions
        function openModal(contentHtml) {
            modalBody.innerHTML = contentHtml;
            modal.classList.remove('opacity-0', 'pointer-events-none');
            modal.querySelector('#modal-content').classList.remove('scale-95');
        }

        function closeModal() {
            modal.querySelector('#modal-content').classList.add('scale-95');
            setTimeout(() => {
                modal.classList.add('opacity-0', 'pointer-events-none');
            }, 300);
        }

        closeModalBtn.addEventListener('click', closeModal);
        modal.addEventListener('click', (e) => {
            if (e.target === modal) closeModal();
        });

        // Generate Guidance Content (Client-side simulation)
        function generateGuidance(data) {
            const petType = data.pet_type || 'N/A';
            const urgency = data.urgency_level || 'N/A';
            const symptoms = data.symptoms || [];
            const isCritical = urgency === 'Critical';

            let guidanceHtml = `<h2 class="text-2xl font-bold mb-4 ${isCritical ? 'text-red-600' : 'text-custom-purple'}">First Aid Guidance</h2>`;
            guidanceHtml += `<div class="p-3 mb-4 rounded-lg ${isCritical ? 'bg-red-100 border border-red-300' : 'bg-green-100 border border-green-300'}">`;
            guidanceHtml += `<p class="font-semibold mb-1">Your Pet: ${petType}</p>`;
            guidanceHtml += `<p class="font-semibold">Urgency: ${urgency}</p>`;
            guidanceHtml += `</div>`;

            if (isCritical) {
                guidanceHtml += `<div class="bg-red-500 text-white p-4 rounded-lg mb-4">
                    <p class="font-bold text-lg mb-2"><i class="fa-solid fa-triangle-exclamation mr-2"></i> EMERGENCY ACTION REQUIRED</p>
                    <p>STOP READING and call your emergency vet immediately: <span class="font-mono">1-888-PET-HELP</span>. Keep your pet calm and restrict movement until directed by a professional.</p>
                </div>`;
            } else if (urgency === 'Urgent') {
                guidanceHtml += `<div class="bg-yellow-500 text-gray-900 p-4 rounded-lg mb-4">
                    <p class="font-bold text-lg mb-2"><i class="fa-solid fa-hand-point-right mr-2"></i> Urgent Care Recommended</p>
                    <p>Contact your regular vet now. While waiting, focus on these steps:</p>
                    <ul class="list-disc list-inside mt-2 text-sm">
                        <li>Maintain a clear airway.</li>
                        <li>Control any visible bleeding by applying direct pressure.</li>
                        <li>Keep your pet warm and transport them safely.</li>
                    </ul>
                </div>`;
            } else {
                 guidanceHtml += `<div class="bg-blue-100 text-gray-800 p-4 rounded-lg mb-4">
                    <p class="font-bold text-lg mb-2"><i class="fa-solid fa-stethoscope mr-2"></i> Recommended Steps</p>
                    <p>Based on symptoms (${symptoms.join(', ') || 'No symptoms checked'}), here are some general first aid steps:</p>
                    <ul class="list-disc list-inside mt-2 text-sm">
                        <li>Clean minor wounds gently with saline solution.</li>
                        <li>Monitor vital signs (breathing, heart rate) closely.</li>
                        <li>Contact your veterinarian during normal business hours for a follow-up appointment.</li>
                    </ul>
                </div>`;
            }
            
            // --- MODAL CONFIRMATION OF FILE UPLOAD ---
            if (data.file_uploaded) {
                guidanceHtml += `<div class="bg-indigo-100 text-indigo-700 p-3 rounded-lg mt-4">
                    <p class="font-semibold"><i class="fa-solid fa-camera mr-2"></i> Image upload(s) saved successfully!</p>
                </div>`;
            }

            guidanceHtml += `<p class="text-sm text-gray-600 mt-4">A complete request has been submitted to our team (Request ID: <span class="font-mono text-custom-purple">XX-XXXX</span>) and you will receive a follow-up email shortly.</p>`;

            return guidanceHtml;
        }

        // Form submission handler
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            submitBtn.textContent = 'Processing...';
            submitBtn.disabled = true;

            // 1. Collect ALL form data, including the file(s), using the FormData API
            const formData = new FormData(form);
            
            // 2. Prepare a text-only data object for client-side guidance generation later
            const guidanceData = {};
            const selectedSymptoms = [];
            
            // Loop through FormData to correctly extract data for client-side display
            formData.forEach((value, key) => {
                if (key === 'symptoms[]') {
                    selectedSymptoms.push(value);
                } else if (key !== 'injury_photo[]') {
                    guidanceData[key] = value;
                }
            });
            guidanceData['symptoms'] = selectedSymptoms;
            
            // 3. Send FormData to the PHP file
            fetch('submit_firstaid.php', {
                method: 'POST',
                body: formData // Sends multipart/form-data for text and files
            })
            .then(response => response.json())
            .then(result => {
                let guidanceHtml;
                if (result.success) {
                    // Success: Show first aid guidance generated client-side
                    const finalGuidanceData = {
                        ...guidanceData, 
                        request_id: result.request_id || 'N/A',
                        file_uploaded: result.file_uploaded || false // Use server flag
                    };
                    guidanceHtml = generateGuidance(finalGuidanceData);
                    
                    // Replace placeholder ID in the success message
                    guidanceHtml = guidanceHtml.replace('XX-XXXX', result.request_id);
                    
                } else {
                    // Failure: Show error message
                    guidanceHtml = `<h2 class="text-2xl font-bold text-red-600 mb-4">Submission Failed</h2>
                                    <p class="text-gray-700">${result.message || 'An unknown error occurred while saving your request to the database.'}</p>
                                    <p class="text-sm text-gray-500 mt-4">Please call the emergency hotline immediately if your pet is critical.</p>`;
                }
                
                openModal(guidanceHtml);

                submitBtn.textContent = 'Get First Aid Guidance';
                submitBtn.disabled = false;
            })
            .catch(error => {
                // Network Error
                console.error('Submission Error:', error);
                const errorHtml = `<h2 class="text-2xl font-bold text-red-600 mb-4">Network Error</h2>
                                   <p class="text-gray-700">Could not connect to the server. Please check your connection or call the emergency hotline immediately.</p>`;
                openModal(errorHtml);
                
                submitBtn.textContent = 'Get First Aid Guidance';
                submitBtn.disabled = false;
            });
        });
    });
</script>