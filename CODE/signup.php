<?php
session_start();
include_once "config.php";

// ======================
// FORM PROCESSING
// ======================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name  = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $contact = trim($_POST['contact_number'] ?? '');
    $pass  = trim($_POST['password'] ?? '');

    // Database connection check
    if ($conn === null || $conn->connect_error) {
        $_SESSION['message'] = "Server configuration error: Database connection not established.";
        $_SESSION['type'] = "error";
        header("Location: signup.php");
        exit();
    }

    // Required fields check
    if ($name === '' || $email === '' || $contact === '' || $pass === '') {
        $_SESSION['message'] = "Please fill all required fields.";
        $_SESSION['type'] = "error";
        header("Location: signup.php");
        exit();
    }

    // FIX: Only check if the email already exists, as requested. (Lines 40-57 handle this check)
    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    if (!$check) {
        $_SESSION['message'] = "Server error. Try again later.";
        $_SESSION['type'] = "error";
        header("Location: signup.php");
        exit();
    }

    $check->bind_param("s", $email); // Only bind email
    $check->execute();
    $check->store_result();
    
    if ($check->num_rows > 0) {
        // Updated error message
        $_SESSION['message'] = "Email already registered!";
        $_SESSION['type'] = "error";
        header("Location: signup.php");
        exit();
    }
    $check->close();

    // Hash password
    $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);

    // Insert new user
    // Line 67 is where the execute() call happens which was throwing the fatal error.
    $insert = $conn->prepare("INSERT INTO users (name, email, contact_number, password) VALUES (?, ?, ?, ?)");
    if (!$insert) {
        $_SESSION['message'] = "Server error. Try again later.";
        $_SESSION['type'] = "error";
        header("Location: signup.php");
        exit();
    }

    $insert->bind_param("ssss", $name, $email, $contact, $hashed_pass);

    if ($insert->execute()) { // This line should now succeed after the database fix.
        $_SESSION['message'] = "Signup successful! You can now log in.";
        $_SESSION['type'] = "success";
        header("Location: login.php");
        exit();
    } else {
        $_SESSION['message'] = "Error registering user. Please try again.";
        $_SESSION['type'] = "error";
        header("Location: signup.php");
        exit();
    }
}
?>

<?php if (!empty($_SESSION['message'])): ?>
<style>
.splash {
    padding: 14px;
    border-radius: 8px;
    font-weight: bold;
    margin: 15px auto;
    max-width: 500px;
    animation: fadeIn 0.3s ease;
}

.splash.success {
    background: #d8ffe4;
    border: 1px solid #9ef5bd;
    color: #0c7a30;
}

.splash.error {
    background: #ffe1e1;
    border: 1px solid #ffb3b3;
    color: #b30000;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-6px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>

<div class="splash <?php echo $_SESSION['type']; ?>">
    <?php 
        echo $_SESSION['message']; 
        unset($_SESSION['message']);
        unset($_SESSION['type']);
    ?>
</div>
<?php endif; ?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Signup</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gradient-to-r from-slate-300 to-slate-500">
    
  <style>
@keyframes halfspin {
  0%   { transform: rotate(0deg); }
  50%  { transform: rotate(180deg); }
  100% { transform: rotate(0deg); }
}
</style>


  <div class="w-full max-w-6xl grid grid-cols-1 md:grid-cols-2 mx-auto py-10 px-6 sm:px-10 gap-6 rounded-2xl shadow-2xl mt-20 bg-[#eff1fd]">

    

    <div class="w-full p-8 sm:p-12 flex flex-col justify-evenly items-center">

        
      <div class="max-w-md mx-auto w-full">

        <div class="flex items-center mb-8 justify-center">
          <span class="text-3xl font-bold text-gray-800">Save Paws</span>
          <span class="text-3xl font-bold text-indigo-600">Club</span>
          <svg class="w-4 h-4 ml-1 text-indigo-600" viewBox="0 0 24 24" fill="currentColor">
            <path d="M12,2A10,10,0,1,0,22,12,10,10,0,0,0,12,2Zm0,18a8,8,0,1,1,8-8A8,8,0,0,1,12,20Z" opacity=".4"/>
            <path d="M12,7a5,5,0,1,0,5,5A5,5,0,0,0,12,7Z"/>
          </svg>
        </div>

        <div class="group transition duration-200">
        <button class="w-full flex items-center justify-center py-3 px-4 border border-[#595ee9] rounded-3xl group-hover:bg-[#595ee9] group-hover:border-black">
          <img src="https://upload.wikimedia.org/wikipedia/commons/c/c1/Google_%22G%22_logo.svg" alt="Google" class="w-5 h-5 mr-3">
          <h1 class="font-medium text-gray-700 group-hover:text-white">SignUp with Google</h1>
        </button>
</div>
        <div class="flex items-center my-8 whitespace-nowrap">
  <hr class="flex-1 border-gray-300">
  <span class="px-5 text-gray-400 text-sm whitespace-nowrap">Or SignUp with Email</span>
  <hr class="flex-1 border-gray-300">
</div>


        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
          <div class="space-y-5">
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" class="text-gray-400"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
              </div>
              <input type="text" placeholder="Name" name="name" required class="w-full pl-10 pr-4 py-3 border border-[#595ee9] rounded-3xl focus:ring-2 focus:ring-indigo-500">
            </div>
            
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" class="text-gray-400"><path d="M4 4h16v16H4z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
              </div>
              <input type="email" name="email" placeholder="Email" required class="w-full pl-10 pr-4 py-3 border border-[#595ee9] rounded-3xl focus:ring-2 focus:ring-indigo-500">
            </div>

        <div class="relative">
    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" class="text-gray-400">
            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-4.5-4.5 19.79 19.79 0 0 1-3.07-8.63A2 2 0 0 1 3.08 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 1 1 0 0 1-.17 1l-2.78 2.78a15.7 15.7 0 0 0 6.8 6.8l2.78-2.78a1 1 0 0 1 1-.17 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
        </svg>
    </div>

    <input
        type="tel"
        placeholder="Contact Number"
        name="contact_number"
        required
        pattern="01[0-9]{9}"
        minlength="11"
        maxlength="11"
        class="w-full pl-10 pr-4 py-3 border border-[#595ee9] rounded-3xl focus:ring-2 focus:ring-indigo-500"
    >
</div>

<p class="text-red-500 text-sm mt-1">Phone must start with 01 and be 11 digits.</p>

            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" class="text-gray-400"><rect x="3" y="11" width="18" height="11" rx="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
              </div>
              <input type="password" placeholder="Password" name="password" required class="w-full pl-10 pr-4 py-3 border border-[#595ee9] rounded-3xl focus:ring-2 focus:ring-indigo-500">
            </div>
          </div>
          <button type="submit" class="cursor-pointer w-full mt-8 py-3 bg-indigo-600 text-white font-semibold rounded-3xl hover:bg-indigo-700 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-300">
            Sign up
          </button>

                <button onclick="window.location.href='guest_rescue.php'" type="button" class="cursor-pointer w-full mt-8 py-3 bg-red-600 text-white font-semibold rounded-3xl hover:bg-red-700 focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-300">
          Guest Mode ->
          </button>
        </form>

        <p class="mt-8 text-center text-sm text-gray-500">
          Already have an account? <a href="login.php" class="font-medium text-indigo-600 hover:underline">Log in</a>
        </p>
      </div>
    </div>


    <div class="flex flex-col md:flex-row w-full bg-indigo-600 p-12 text-white items-start justify-center rounded-4xl md:round-4xl relative overflow-visible">

  <div class="max-w-sm relative z-40">
    <h2 class="text-4xl font-bold mb-4">Save Paws Club</h2>
    <p class="text-white text-sm font-extrabold">
      All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary.
      All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary.
      All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary.
      All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary.
    </p>
  </div>

  <div class="flex flex-row items-center gap-6 mt-6 md:mt-0 md:block w-full md:w-auto">
    <img src="https://images.unsplash.com/photo-1580489944761-15a19d654956?q=80&w=400" 
         alt="Pet owner" 
         class="w-24 h-24 md:w-30 md:h-30 rounded-full object-cover border-4 border-indigo-700 md:absolute md:top-5 md:-right-10 animate-[halfspin_2s_ease-in-out]">

    <img src="https://images.unsplash.com/photo-1596854407944-bf87f6fdd49e?q=80&w=400" 
         alt="Happy pet owner" 
         class="w-24 h-24 md:w-30 md:h-30 rounded-full object-cover border-4 border-indigo-700 md:absolute md:bottom-40 md:-left-12 animate-[halfspin_2s_ease-in-out]">
  </div>
  
  <div class="hidden md:block absolute -bottom-10 -right-60">
    <img src="img/istockphoto-1210732343-170667a-removebg-preview.png" 
         alt="Man with a dog" 
         class="object-cover w-full md:w-full size-96">
  </div>
</div>
</body>
</html>