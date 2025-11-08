<?php
// config.php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "savepaws";

// Create mysqli connection (object oriented)
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    // Note: In a production environment, you should log the error and display a generic message
    die("Database Connection Failed: " . $conn->connect_error);
}

// Optional: set charset
$conn->set_charset("utf8mb4");

// NOTE: This file handles the display; submission logic is moved to submit_appointment.php
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SavePaws - Clinic Appointments</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        /* A little custom CSS to ensure calendar days are square and centered */
        .calendar-day {
            aspect-ratio: 1 / 1;
        }
    </style>
</head>

<body class="bg-gray-50">

    <nav class="flex flex-wrap justify-between items-center py-4 bg-white shadow-lg sticky top-0 z-40">
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
        <div class="hidden lg:flex sm:hidden items-center space-x-2 lg:space-x-5 mr-5">
            <div class="flex justify-center items-center">
                <a href="login.php" class="text-sm lg:text-sm font-bold text-black hover:text-indigo-600">Logout</a>
over:text-indigo-600"></a>
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
                <a href="login.php" class="text-sm lg:text-sm font-bold text-black hover:text-indigo-600">Logout</a>
            </div>
        </div>
        <li><a href="gst.php" class="text-lg font-bold text-black hover:text-indigo-600">Home</a></li>
        <li><a href="marketplace.php" class="text-lg font-bold text-black hover:text-indigo-600">Shop</a></li>
        <li><a href="clinic.php" class="text-lg font-bold text-black hover:text-indigo-600">Clinics</a></li>
        <li><a href="rescue.php" class="text-lg font-bold text-black hover:text-indigo-600">Rescue Team</a></li>
        <li><a href="blog.php" class="text-lg font-bold text-black hover:text-indigo-600">Blog</a></li>
        <li><a href="adopt.php" class="text-lg font-bold text-black hover:text-indigo-600">Adopt</a></li>
        <li><a href="donation.php" class="text-lg font-bold text-black hover:text-indigo-600">Donate</a></li>
    </ul>

    <div class="min-h-screen">
        <main class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <div class="bg-white p-6 rounded-xl shadow-2xl lg:col-span-1 border-t-4 border-indigo-600 flex flex-col">
                    <div class="flex items-center space-x-4 mb-4">
                        <div class="flex-shrink-0"><img class="h-16 w-16 rounded-full bg-gray-300" src="img/urmi.png" alt="Dr. Urmi"></div>
                        <div>
                            <h2 class="text-xl font-extrabold text-gray-900">Dr. Urmi</h2>
                            <p class="text-sm text-gray-500">Cardiology & Internal Medicine</p>
                        </div>
                    </div>
                    <div class="border-t border-gray-200 mb-4"></div>
                    <div class="space-y-3 text-sm text-gray-600 mb-6">
                        <p class="flex items-center"><i class="fa-solid fa-user-doctor w-5 text-indigo-500"></i><span>MBBS, MD (Cardiology)</span></p>
                        <p class="flex items-center"><i class="fa-solid fa-briefcase w-5 text-indigo-500"></i><span>8+ Years of Experience</span></p>
                        <p class="flex items-center"><i class="fa-solid fa-money-bill-wave w-5 text-indigo-500"></i><span>Consultation Fee: $50</span></p>
                        <div class="flex items-center text-green-600 font-semibold pt-2">
                           <i class="fa-solid fa-circle text-xs mr-2 animate-pulse"></i>
                           <span>Available Now</span>
                        </div>
                    </div>
                    <p class="text-gray-700 text-sm mb-6 flex-grow">A short bio from Dr. Urmi about her practice and dedication to pet wellness. Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                    <div class="space-y-3 mt-auto">
                        <button class="open-modal-btn w-full py-3 bg-indigo-600 text-white font-bold rounded-lg shadow-md hover:bg-indigo-700 transition duration-150 text-center" data-doctor-name="Dr. Urmi" data-doctor-specialty="Cardiology & Internal Medicine">Book an Appointment</button>
                        <a href="https://meet.google.com/new" target="_blank" class="block text-center w-full py-3 text-indigo-600 border border-indigo-600 font-medium rounded-lg hover:bg-indigo-50 transition duration-150">Online Counseling (Meet)</a>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-2xl lg:col-span-2 doctor-details-panel">
                    <div class="border-b border-gray-200 mb-4">
                        <nav class="-mb-px flex space-x-6" aria-label="Tabs">
                            <button class="tab-btn whitespace-nowrap py-3 px-1 border-b-2 font-medium text-sm border-indigo-600 text-indigo-600" data-tab="about1">About</button>
                            <button class="tab-btn whitespace-nowrap py-3 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300" data-tab="publications1">Publications</button>
                            <button class="tab-btn whitespace-nowrap py-3 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300" data-tab="achievements1">Achievements</button>
                        </nav>
                    </div>

                    <div>
                        <div class="tab-content" id="about1">
                             <h3 class="text-lg font-bold text-gray-800 mb-2">About Dr. Urmi</h3>
                             <p class="text-sm text-gray-600 leading-relaxed mb-4">Dr. Urmi is a board-certified veterinary cardiologist with a deep-seated passion for improving the lives of pets through advanced cardiac care and internal medicine. Her approach combines cutting-edge diagnostics with compassionate, personalized treatment plans.</p>
                             <h4 class="font-semibold text-gray-700 mb-2">Education & Study Life</h4>
                             <p class="text-sm text-gray-600 leading-relaxed">She completed her Bachelor of Veterinary Science from the esteemed Royal Veterinary College, followed by a rigorous residency in cardiology. She is committed to lifelong learning and frequently attends international conferences to stay abreast of the latest advancements in veterinary medicine.</p>
                        </div>
                        <div class="tab-content hidden" id="publications1">
                             <h3 class="text-lg font-bold text-gray-800 mb-3">Publications & Research</h3>
                             <ul class="space-y-3 text-sm text-gray-600">
                                <li class="flex items-start"><i class="fa-solid fa-book-open w-5 mt-1 text-indigo-500"></i><span><strong>Book:</strong> "The Healthy Pet Heart: A Guide for Owners" - An accessible guide on preventative care for pet cardiovascular health.</span></li>
                                <li class="flex items-start"><i class="fa-solid fa-file-alt w-5 mt-1 text-indigo-500"></i><span><strong>Research Paper:</strong> "Novel Echocardiographic Techniques in Feline Hypertrophic Cardiomyopathy" - Published in the Journal of Veterinary Internal Medicine.</span></li>
                                <li class="flex items-start"><i class="fa-solid fa-newspaper w-5 mt-1 text-indigo-500"></i><span><strong>Article:</strong> "Managing Chronic Valvular Disease in Senior Dogs" - Featured in Pet Wellness Magazine.</span></li>
                             </ul>
                        </div>
                        <div class="tab-content hidden" id="achievements1">
                            <h3 class="text-lg font-bold text-gray-800 mb-3">Awards & Recognitions</h3>
                             <ul class="space-y-3 text-sm text-gray-600 list-disc list-inside">
                                 <li>Veterinarian of the Year - National Pet Health Association (2021)</li>
                                 <li>Excellence in Research Award - American College of Veterinary Internal Medicine</li>
                                 <li>Community Service Award for providing pro-bono services to local animal shelters.</li>
                             </ul>
                        </div>
                    </div>
                </div>


                <div class="bg-white p-6 rounded-xl shadow-2xl lg:col-span-1 border-t-4 border-indigo-600 flex flex-col">
                    <div class="flex items-center space-x-4 mb-4">
                        <div class="flex-shrink-0"><img class="h-16 w-16 rounded-full bg-gray-300" src="img/rohit.png" alt="Dr. Jakir"></div>
                        <div>
                            <h2 class="text-xl font-extrabold text-gray-900">Dr. Jakir</h2>
                            <p class="text-sm text-gray-500">General Veterinary Medicine</p>
                        </div>
                    </div>
                    <div class="border-t border-gray-200 mb-4"></div>
                    <div class="space-y-3 text-sm text-gray-600 mb-6">
                        <p class="flex items-center"><i class="fa-solid fa-user-doctor w-5 text-indigo-500"></i><span>DVM (Veterinary Medicine)</span></p>
                        <p class="flex items-center"><i class="fa-solid fa-briefcase w-5 text-indigo-500"></i><span>5+ Years of Experience</span></p>
                        <p class="flex items-center"><i class="fa-solid fa-money-bill-wave w-5 text-indigo-500"></i><span>Consultation Fee: $40</span></p>
                        <div class="flex items-center text-red-600 font-semibold pt-2">
                           <i class="fa-solid fa-circle text-xs mr-2"></i>
                           <span>Currently Busy</span>
                        </div>
                    </div>
                    <p class="text-gray-700 text-sm mb-6 flex-grow">A short bio from Dr. Jakir about his practice and dedication to pet wellness. Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                    <div class="space-y-3 mt-auto">
                        <button class="open-modal-btn w-full py-3 bg-indigo-600 text-white font-bold rounded-lg shadow-md hover:bg-indigo-700 transition duration-150 text-center" data-doctor-name="Dr. Jakir" data-doctor-specialty="General Veterinary Medicine">Book an Appointment</button>
                        <a href="https://meet.google.com/new" target="_blank" class="block text-center w-full py-3 text-indigo-600 border border-indigo-600 font-medium rounded-lg hover:bg-indigo-50 transition duration-150">Online Counseling (Meet)</a>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-2xl lg:col-span-2 doctor-details-panel">
                    <div class="border-b border-gray-200 mb-4">
                        <nav class="-mb-px flex space-x-6" aria-label="Tabs">
                            <button class="tab-btn whitespace-nowrap py-3 px-1 border-b-2 font-medium text-sm border-indigo-600 text-indigo-600" data-tab="about2">About</button>
                            <button class="tab-btn whitespace-nowrap py-3 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300" data-tab="publications2">Publications</button>
                            <button class="tab-btn whitespace-nowrap py-3 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300" data-tab="achievements2">Achievements</button>
                        </nav>
                    </div>

                    <div>
                        <div class="tab-content" id="about2">
                             <h3 class="text-lg font-bold text-gray-800 mb-2">About Dr. Jakir</h3>
                             <p class="text-sm text-gray-600 leading-relaxed mb-4">Dr. Jakir is a dedicated general practitioner with a focus on preventative care and client education. He believes that a well-informed owner is a pet's best advocate and strives to build strong, collaborative relationships with all his clients.</p>
                             <h4 class="font-semibold text-gray-700 mb-2">Education & Study Life</h4>
                             <p class="text-sm text-gray-600 leading-relaxed">He earned his Doctor of Veterinary Medicine (DVM) from Cornell University College of Veterinary Medicine. His primary interests include dermatology and animal behavior, and he has pursued additional certifications in both areas to better serve his patients.</p>
                        </div>
                        <div class="tab-content hidden" id="publications2">
                             <h3 class="text-lg font-bold text-gray-800 mb-3">Blog & Articles</h3>
                             <ul class="space-y-3 text-sm text-gray-600">
                                <li class="flex items-start"><i class="fa-solid fa-blog w-5 mt-1 text-indigo-500"></i><span><strong>Blog Post:</strong> "Decoding Your Dog's Body Language" - A popular series on his clinic's website.</span></li>
                                <li class="flex items-start"><i class="fa-solid fa-newspaper w-5 mt-1 text-indigo-500"></i><span><strong>Article:</strong> "Seasonal Allergies in Pets: A Proactive Approach" - Contributor to 'Modern Pet Owner' online journal.</span></li>
                             </ul>
                        </div>
                        <div class="tab-content hidden" id="achievements2">
                            <h3 class="text-lg font-bold text-gray-800 mb-3">Awards & Recognitions</h3>
                             <ul class="space-y-3 text-sm text-gray-600 list-disc list-inside">
                                 <li>Rising Star Award - State Veterinary Medical Association (2022)</li>
                                 <li>Pet Advocate Award for his work in promoting responsible pet ownership in the community.</li>
                             </ul>
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>

    <footer class="bg-[#1A253DF0] text-white py-12 px-6 w-full"></footer>

    <div id="appointmentModal" class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center p-4 z-50 opacity-0 pointer-events-none transition-opacity duration-300">
        <div id="modalContent" class="bg-gray-50 rounded-2xl shadow-2xl w-full max-w-4xl transform transition-transform duration-300 scale-95 max-h-[90vh] flex flex-col relative overflow-hidden">
            
            <div id="confirmationMessage" class="absolute inset-0 bg-white bg-opacity-95 z-20 flex flex-col items-center justify-center opacity-0 pointer-events-none transition-opacity duration-300">
                <div class="bg-green-500 rounded-full p-4"><i class="fa-solid fa-check text-5xl text-white"></i></div>
                <h3 class="text-2xl font-bold text-gray-800 mt-4">Appointment Booked!</h3>
                <p class="text-gray-600">You will receive an email with the details shortly.</p>
            </div>
            
            <div class="flex-shrink-0 flex justify-between items-start p-6 border-b border-gray-200 bg-white">
                <div>
                    <h3 class="text-2xl font-bold text-gray-800" id="modalDoctorName">Book an Appointment</h3>
                    <p class="text-sm text-gray-500" id="modalDoctorSpecialty">Select a date and time that works for you.</p>
                </div>
                <button id="closeModalBtn" class="text-gray-400 hover:text-gray-600 transition"><i class="fa-solid fa-xmark text-2xl"></i></button>
            </div>

            <div class="flex-grow p-4 md:p-6 overflow-y-auto">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    
                    <div class="bg-white p-4 rounded-lg shadow-sm">
                        <div class="flex items-center justify-between mb-4">
                            <button id="prevMonth" class="p-2 rounded-full hover:bg-gray-100 text-gray-500" aria-label="Previous month"><i class="fa-solid fa-chevron-left"></i></button>
                            <h4 id="monthYear" class="text-lg font-semibold text-gray-800"></h4>
                            <button id="nextMonth" class="p-2 rounded-full hover:bg-gray-100 text-gray-500" aria-label="Next month"><i class="fa-solid fa-chevron-right"></i></button>
                        </div>
                        <div class="grid grid-cols-7 gap-1 text-center text-xs text-gray-500 mb-2 font-semibold">
                            <div>SUN</div><div>MON</div><div>TUE</div><div>WED</div><div>THU</div><div>FRI</div><div>SAT</div>
                        </div>
                        <div id="calendarGrid" class="grid grid-cols-7 gap-1"></div>
                    </div>

                    <div id="detailsPanel" class="space-y-6">
                        <div class="bg-white p-4 rounded-lg shadow-sm">
                            <h4 class="font-semibold text-gray-700 mb-3" id="selectedDateText">Please select a date</h4>
                            <div id="timeSlotsContainer" class="grid grid-cols-3 sm:grid-cols-4 gap-3"></div>
                        </div>
                        <div class="bg-white p-4 rounded-lg shadow-sm">
                            <h4 class="font-semibold text-gray-700 mb-3">Patient Details</h4>
                            <form id="patientForm" class="space-y-4">
                                <div>
                                    <label for="patientName" class="text-sm font-medium text-gray-600">Patient's Name</label>
                                    <input type="text" id="patientName" name="patientName" class="mt-1 w-full p-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" required>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="contactNumber" class="text-sm font-medium text-gray-600">Contact Number</label>
                                        <input type="tel" id="contactNumber" name="contactNumber" class="mt-1 w-full p-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" required>
                                    </div>
                                    <div>
                                        <label for="email" class="text-sm font-medium text-gray-600">Email Address</label>
                                        <input type="email" id="email" name="email" class="mt-1 w-full p-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                                    </div>
                                </div>
                                 <div>
                                    <label for="nidNumber" class="text-sm font-medium text-gray-600">Owner's NID (Optional)</label>
                                    <input type="text" id="nidNumber" name="nidNumber" class="mt-1 w-full p-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                                </div>
                                <div>
                                    <label for="problemDescription" class="text-sm font-medium text-gray-600">Reason for Visit</label>
                                    <textarea id="problemDescription" name="problemDescription" rows="3" class="mt-1 w-full p-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" placeholder="Briefly describe the patient's problem..." required></textarea>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex-shrink-0 bg-white p-4 border-t border-gray-200">
                <button id="confirmAppointmentBtn" class="w-full py-3 bg-indigo-600 text-white font-bold rounded-lg shadow-md hover:bg-indigo-700 transition duration-150 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:bg-gray-400 disabled:cursor-not-allowed" disabled>
                    Complete selections and form to continue
                </button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile Menu Toggle
            const menuBtn = document.getElementById('menu-btn');
            const mobileMenu = document.getElementById('mobile-menu');
            if (menuBtn) {
                 menuBtn.addEventListener('click', () => mobileMenu.classList.toggle('hidden'));
            }

            // Doctor Details Tab Logic
            const doctorDetailsPanels = document.querySelectorAll('.doctor-details-panel');
            doctorDetailsPanels.forEach(panel => {
                const tabs = panel.querySelectorAll('.tab-btn');
                const contents = panel.querySelectorAll('.tab-content');

                tabs.forEach(tab => {
                    tab.addEventListener('click', () => {
                        // Deactivate all tabs and content within this panel
                        tabs.forEach(item => {
                            item.classList.remove('border-indigo-600', 'text-indigo-600');
                            item.classList.add('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
                        });
                        contents.forEach(content => content.classList.add('hidden'));

                        // Activate the clicked tab and its content
                        tab.classList.add('border-indigo-600', 'text-indigo-600');
                        tab.classList.remove('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
                        const activeContent = panel.querySelector(`#${tab.dataset.tab}`);
                        if(activeContent) activeContent.classList.remove('hidden');
                    });
                });
            });


            // Modal Appointment Logic
            const modal = document.getElementById('appointmentModal');
            const modalContent = document.getElementById('modalContent');
            const closeModalBtn = document.getElementById('closeModalBtn');
            const confirmBtn = document.getElementById('confirmAppointmentBtn');
            const confirmationMessage = document.getElementById('confirmationMessage');
            const modalDoctorName = document.getElementById('modalDoctorName');
            const modalDoctorSpecialty = document.getElementById('modalDoctorSpecialty');
            
            const calendarGrid = document.getElementById('calendarGrid');
            const monthYearEl = document.getElementById('monthYear');
            const prevMonthBtn = document.getElementById('prevMonth');
            const nextMonthBtn = document.getElementById('nextMonth');
            const selectedDateText = document.getElementById('selectedDateText');
            const timeSlotsContainer = document.getElementById('timeSlotsContainer');
            const patientForm = document.getElementById('patientForm');
            
            let currentDate = new Date();
            
            const state = {
                doctorName: '',
                doctorSpecialty: '',
                selectedDate: null,
                selectedTime: null,
                unavailableDates: ["2025-11-15", "2025-11-28"],
                reset: function() {
                    this.selectedDate = null;
                    this.selectedTime = null;
                }
            };

            function updateConfirmButton() {
                const isFormValid = patientForm.checkValidity(); // Checks all required fields
                if (state.selectedDate && state.selectedTime && isFormValid) {
                    confirmBtn.disabled = false;
                    confirmBtn.textContent = `Confirm Appointment for ${state.selectedTime}`;
                } else {
                    confirmBtn.disabled = true;
                    confirmBtn.textContent = 'Complete selections and form to continue';
                }
            }
            
            patientForm.addEventListener('input', updateConfirmButton);

            const generateCalendar = (year, month) => {
                calendarGrid.innerHTML = '';
                const today = new Date();
                today.setHours(0, 0, 0, 0);

                const monthName = new Date(year, month).toLocaleString('default', { month: 'long' });
                monthYearEl.textContent = `${monthName} ${year}`;

                const firstDayOfMonth = new Date(year, month, 1).getDay();
                const daysInMonth = new Date(year, month + 1, 0).getDate();

                for (let i = 0; i < firstDayOfMonth; i++) calendarGrid.insertAdjacentHTML('beforeend', '<div></div>');

                for (let i = 1; i <= daysInMonth; i++) {
                    const dayDate = new Date(year, month, i);
                    const dateString = `${year}-${String(month + 1).padStart(2, '0')}-${String(i).padStart(2, '0')}`;
                    const isPast = dayDate < today;
                    const isToday = dayDate.getTime() === today.getTime();
                    const isUnavailable = state.unavailableDates.includes(dateString) || dayDate.getDay() === 0;
                    
                    let dayClasses = 'calendar-day flex items-center justify-center rounded-full text-sm font-medium';
                    
                    if (isPast || isUnavailable) {
                        dayClasses += ' text-gray-300 cursor-not-allowed';
                    } else {
                        dayClasses += ' cursor-pointer hover:bg-indigo-100 text-gray-700';
                    }
                    if (isToday && !state.selectedDate && !isUnavailable && !isPast) {
                        dayClasses += ' bg-indigo-600 text-white';
                    }
                     if (state.selectedDate && dayDate.getTime() === state.selectedDate.getTime()) {
                        // Apply selected style to the selected date only
                        const selectedDateString = `${state.selectedDate.getFullYear()}-${String(state.selectedDate.getMonth() + 1).padStart(2, '0')}-${String(state.selectedDate.getDate()).padStart(2, '0')}`;
                        if (selectedDateString === dateString) {
                            dayClasses += ' border-2 border-indigo-500 bg-indigo-100 text-indigo-600 font-bold';
                        }
                    }

                    calendarGrid.insertAdjacentHTML('beforeend', `<div class="${dayClasses}" data-day="${i}">${i}</div>`);
                }
            };
            
            calendarGrid.addEventListener('click', (e) => {
                const dayEl = e.target.closest('[data-day]');
                if (dayEl && !dayEl.classList.contains('cursor-not-allowed')) {
                    // Remove current selection style from all days
                    calendarGrid.querySelectorAll('.calendar-day').forEach(day => {
                        day.classList.remove('border-2', 'border-indigo-500', 'bg-indigo-100', 'text-indigo-600', 'font-bold');
                    });
                    
                    const day = parseInt(dayEl.dataset.day);
                    state.selectedDate = new Date(currentDate.getFullYear(), currentDate.getMonth(), day);
                    state.selectedTime = null; // Reset time selection on new date selection
                    
                    // Apply new selection style
                    dayEl.classList.add('border-2', 'border-indigo-500', 'bg-indigo-100', 'text-indigo-600', 'font-bold');
                    
                    generateTimeSlots();
                    updateConfirmButton();
                    
                    selectedDateText.textContent = `Available slots for ${state.selectedDate.toLocaleDateString('en-US', { weekday: 'long', month: 'long', day: 'numeric' })}`;
                }
            });

            prevMonthBtn.addEventListener('click', () => {
                currentDate.setMonth(currentDate.getMonth() - 1);
                state.selectedDate = null; // Reset date selection when changing month
                state.selectedTime = null; // Reset time selection when changing month
                selectedDateText.textContent = `Please select a date`;
                generateCalendar(currentDate.getFullYear(), currentDate.getMonth());
                generateTimeSlots();
                updateConfirmButton();
            });

            nextMonthBtn.addEventListener('click', () => {
                currentDate.setMonth(currentDate.getMonth() + 1);
                state.selectedDate = null; // Reset date selection when changing month
                state.selectedTime = null; // Reset time selection when changing month
                selectedDateText.textContent = `Please select a date`;
                generateCalendar(currentDate.getFullYear(), currentDate.getMonth());
                generateTimeSlots();
                updateConfirmButton();
            });
            
            const generateTimeSlots = () => {
                timeSlotsContainer.innerHTML = '';
                const slots = ["09:00 AM", "10:00 AM", "11:00 AM", "02:00 PM", "03:00 PM", "04:00 PM"];
                
                if (!state.selectedDate) {
                    timeSlotsContainer.innerHTML = `<p class="text-sm text-gray-500 col-span-full">Select a date to see available time slots.</p>`;
                    return;
                }

                slots.forEach(slot => {
                    const isSelected = state.selectedTime === slot;
                    const button = document.createElement('button');
                    button.type = 'button';
                    button.textContent = slot;
                    button.dataset.time = slot;
                    button.className = `px-4 py-2 text-sm font-medium border rounded-lg transition ${isSelected ? 'bg-indigo-600 text-white border-indigo-600 shadow-md' : 'hover:border-indigo-500 hover:text-indigo-500'}`;
                    timeSlotsContainer.appendChild(button);
                });
            };

            timeSlotsContainer.addEventListener('click', (e) => {
                const timeEl = e.target.closest('[data-time]');
                if (timeEl) {
                    state.selectedTime = timeEl.dataset.time;
                    generateTimeSlots();
                    updateConfirmButton();
                }
            });

            const openModal = (doctorName, doctorSpecialty) => {
                state.doctorName = doctorName;
                state.doctorSpecialty = doctorSpecialty;
                modalDoctorName.textContent = `Appointment with ${doctorName}`;
                modalDoctorSpecialty.textContent = doctorSpecialty;
                
                state.reset();
                currentDate = new Date();
                patientForm.reset();
                selectedDateText.textContent = `Please select a date`;
                
                generateCalendar(currentDate.getFullYear(), currentDate.getMonth());
                generateTimeSlots();
                updateConfirmButton();

                modal.classList.remove('pointer-events-none', 'opacity-0');
                modalContent.classList.remove('scale-95');
            };

            const closeModal = () => {
                modalContent.classList.add('scale-95');
                modal.classList.add('opacity-0');
                // Use a short delay for the animation to complete
                setTimeout(() => {
                    modal.classList.add('pointer-events-none');
                    // Reset confirmation state
                    confirmationMessage.querySelector('.bg-red-500')?.classList.replace('bg-red-500', 'bg-green-500');
                    confirmationMessage.querySelector('i')?.classList.replace('fa-times', 'fa-check');
                    confirmationMessage.classList.add('opacity-0', 'pointer-events-none');
                }, 300);
            };

            // FIX: Using Event Delegation for "Book an Appointment" buttons
            document.body.addEventListener('click', (e) => {
                const btn = e.target.closest('.open-modal-btn');
                if (btn) {
                    e.preventDefault(); 
                    const doctorName = btn.getAttribute('data-doctor-name');
                    const doctorSpecialty = btn.getAttribute('data-doctor-specialty');
                    openModal(doctorName, doctorSpecialty);
                }
            });
            
            closeModalBtn.addEventListener('click', closeModal);
            modal.addEventListener('click', (e) => { if (e.target === modal) closeModal(); });
            document.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeModal(); });

            // AJAX Submission Handler
            confirmBtn.addEventListener('click', () => {
                if (confirmBtn.disabled || !patientForm.checkValidity()) return;
                
                // Format the selected date for the database (YYYY-MM-DD)
                const appointmentDate = state.selectedDate.toISOString().split('T')[0];

                // Format the selected time for the database (HH:MM:SS) 
                const timeParts = state.selectedTime.match(/(\d+):(\d+) (AM|PM)/);
                let hour = parseInt(timeParts[1]);
                const minute = timeParts[2];
                const ampm = timeParts[3];

                if (ampm === 'PM' && hour !== 12) hour += 12;
                if (ampm === 'AM' && hour === 12) hour = 0;
                
                const appointmentTime = `${String(hour).padStart(2, '0')}:${minute}:00`;
                
                const appointmentData = {
                    doctorName: state.doctorName,
                    doctorSpecialty: state.doctorSpecialty,
                    appointmentDate: appointmentDate,
                    appointmentTime: appointmentTime,
                    patientName: document.getElementById('patientName').value,
                    contactNumber: document.getElementById('contactNumber').value,
                    email: document.getElementById('email').value,
                    nidNumber: document.getElementById('nidNumber').value,
                    problemDescription: document.getElementById('problemDescription').value
                };
                
                confirmBtn.disabled = true;
                confirmBtn.textContent = 'Booking...';

                // Send data to PHP script
                fetch('submit_appointment.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(appointmentData)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Show success message
                        confirmationMessage.querySelector('.bg-green-500').classList.remove('bg-red-500');
                        confirmationMessage.querySelector('i').classList.replace('fa-times', 'fa-check');
                        confirmationMessage.querySelector('h3').textContent = "Appointment Booked!";
                        confirmationMessage.querySelector('p').textContent = `Your appointment with ${state.doctorName} on ${state.selectedDate.toLocaleDateString()} at ${state.selectedTime} is confirmed.`;
                        confirmationMessage.classList.remove('opacity-0', 'pointer-events-none');
                        
                        // Close modal after a delay
                        setTimeout(() => closeModal(), 3000);
                    } else {
                        // Show error message
                        confirmationMessage.querySelector('.bg-green-500').classList.replace('bg-green-500', 'bg-red-500');
                        confirmationMessage.querySelector('i').classList.replace('fa-check', 'fa-times');
                        confirmationMessage.querySelector('h3').textContent = "Booking Failed!";
                        confirmationMessage.querySelector('p').textContent = data.message || "Please try again later. (Error: " + (data.error || "Unknown") + ")";
                        confirmationMessage.classList.remove('opacity-0', 'pointer-events-none');
                        
                        // Re-enable button
                        confirmBtn.disabled = false;
                        confirmBtn.textContent = `Try Again`;
                        
                        // Close after a delay, but longer for an error
                        setTimeout(() => {
                             confirmationMessage.classList.add('opacity-0', 'pointer-events-none');
                             updateConfirmButton();
                        }, 5000);
                    }
                })
                .catch(error => {
                    console.error('Submission Error:', error);
                    // Handle network/fetch error
                    confirmationMessage.querySelector('.bg-green-500').classList.replace('bg-green-500', 'bg-red-500');
                    confirmationMessage.querySelector('i').classList.replace('fa-check', 'fa-times');
                    confirmationMessage.querySelector('h3').textContent = "Network Error!";
                    confirmationMessage.querySelector('p').textContent = "Could not connect to the server. Check your connection.";
                    confirmationMessage.classList.remove('opacity-0', 'pointer-events-none');
                    
                    // Re-enable button
                    confirmBtn.disabled = false;
                    confirmBtn.textContent = `Try Again`;
                     
                    setTimeout(() => {
                        confirmationMessage.classList.add('opacity-0', 'pointer-events-none');
                        updateConfirmButton();
                    }, 5000);
                });
            });
            // Initial call to set up the calendar and button state
            generateCalendar(currentDate.getFullYear(), currentDate.getMonth());
            updateConfirmButton();
        });
    </script>
</body>
</html>