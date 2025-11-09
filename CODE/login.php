<?php
session_start();
include_once "config.php";

// -----------------------
// Login Processing
// -----------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Check DB connection
    if ($conn === null || $conn->connect_error) {
        $_SESSION['message'] = "Server error: Database connection failed.";
        $_SESSION['type'] = "error";
        header("Location: login.php");
        exit();
    }

    $email = trim($_POST['email'] ?? '');
    $pass  = trim($_POST['password'] ?? '');

    // Required fields
    if ($email === '' || $pass === '') {
        $_SESSION['message'] = "Please enter email and password.";
        $_SESSION['type'] = "error";
        header("Location: login.php");
        exit();
    }

    // Fetch user by email
    $stmt = $conn->prepare("SELECT id, name, password FROM users WHERE email = ?");
    if (!$stmt) {
        $_SESSION['message'] = "Server error. Try again later.";
        $_SESSION['type'] = "error";
        header("Location: login.php");
        exit();
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // If email exists
    if ($stmt->num_rows === 1) {

        $stmt->bind_result($id, $name, $hash);
        $stmt->fetch();

        // Check password
        if (password_verify($pass, $hash)) {

            session_regenerate_id(true);
            $_SESSION['user_id']   = $id;
            $_SESSION['user_name'] = $name;
            $_SESSION['email']     = $email;

            header("Location: gst.php");
            exit();

        } else {

            $_SESSION['message'] = "Invalid email or password.";
            $_SESSION['type'] = "error";
            header("Location: login.php");
            exit();
        }

    } else {

        $_SESSION['message'] = "Invalid email or password.";
        $_SESSION['type'] = "error";
        header("Location: login.php");
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
  <title>Login</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <script src="https://accounts.google.com/gsi/client" async defer></script>

</head>
<body class="bg-gradient-to-r from-slate-300 to-slate-500">
    
  <style>
@keyframes halfspin {
  0%   { transform: rotate(0deg); }
  50%  { transform: rotate(180deg); }
  100% { transform: rotate(0deg); }
}

</style>


  <div class="w-full max-w-6xl animate-scale-up-top-normal grid grid-cols-1 md:grid-cols-2 mx-auto py-10 px-6 sm:px-10 gap-6 rounded-2xl shadow-2xl mt-20 bg-[#eff1fd]">


    <div class="w-full p-8 sm:p-12 flex flex-col justify-evenly items-center">

        
      <div class="max-w-md mx-auto w-full">

        <div class="flex items-center mb-8 justify-center">
          <span class="text-3xl font-bold text-gray-800">Save Paws</span>
          <span class="text-3xl font-bold text-indigo-600">Club</span>
          <svg class="w-4 h-4 ml-1 text-indigo-600" viewBox="0 24 24" fill="currentColor">
            <path d="M12,2A10,10,0,1,0,22,12,10,10,0,0,0,12,2Zm0,18a8,8,0,1,1,8-8A8,8,0,0,1,12,20Z" opacity=".4"/>
            <path d="M12,7a5,5,0,1,0,5,5A5,5,0,0,0,12,7Z"/>
          </svg>
        </div>

        <div class="group transition duration-200">
<button id="googleLoginBtnTop" class="w-full flex items-center justify-center py-3 px-4 border border-[#595ee9] rounded-3xl cursor-pointer hover:bg-[#595ee9] hover:border-black">
  <img src="https://upload.wikimedia.org/wikipedia/commons/c/c1/Google_%22G%22_logo.svg" alt="Google" class="w-5 h-5 mr-3">
  <span class="font-medium text-gray-700 hover:text-white">Login with Google</span>
</button>

</div>
        <div class="flex items-center my-8 whitespace-nowrap">
  <hr class="flex-1 border-gray-300">
  <span class="px-5 text-gray-400 text-sm whitespace-nowrap">Or Login with Email</span>
  <hr class="flex-1 border-gray-300">
</div>


        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
          <div class="space-y-5">
            <div class="relative">
 
            
            </div>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" class="text-gray-400"><path d="M4 4h16v16H4z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
              </div>
              <input type="email" name="email" placeholder="Email" required class="w-full pl-10 pr-4 py-3 border border-[#595ee9] rounded-3xl focus:ring-2 focus:ring-indigo-500">
            </div>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" class="text-gray-400"><rect x="3" y="11" width="18" height="11" rx="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
              </div>
              <input type="password" name="password" placeholder="Password" required class="w-full pl-10 pr-4 py-3 border border-[#595ee9] rounded-3xl focus:ring-2 focus:ring-indigo-500 ">
            </div>
          </div>

          <div class="mt-6">
          <button type="submit" class="w-full py-3 px-30  bg-indigo-600 text-white font-semibold rounded-3xl hover:bg-indigo-700  transition duration-300 sm:px-30 lg:px-48 " >
            Login
          </button>
          </div>
        </form>

        <p class="mt-8 text-center text-sm text-gray-500">
          Don't have an account Yet? <a href="signup.php" class="font-medium text-indigo-600 hover:underline">Sign up</a>
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
  
  <div class="hidden md:block absolute -bottom-10 -right-40">
    <img src="img/ffa195d9d22333a0cefa67a6058e8b50-removebg-preview.png" 
         alt="Man with a dog" 
         class="object-cover w-full md:w-full size-80">
  </div>
</div>

<button id="googleLoginBtnBottom" class="hidden w-full flex items-center justify-center py-3 px-4 border border-[#595ee9] rounded-3xl cursor-pointer hover:bg-[#595ee9] hover:border-black">
  <img src="https://upload.wikimedia.org/wikipedia/commons/c/c1/Google_%22G%22_logo.svg" alt="Google" class="w-5 h-5 mr-3">
  <span class="font-medium text-gray-700 hover:text-white">Login with Google</span>
</button>

  <script>
// Attach the login script to the visible button (googleLoginBtnTop)
document.getElementById("googleLoginBtnTop").onclick = () => {
  const client_id = "683145627779-jhg2l0hfr889el6co1otjrre0pequors.apps.googleusercontent.com"; //
  const redirect_uri = "http://localhost/CODE/gst.php"; //
  const scope = "email profile"; //
  const response_type = "code"; //

  const oauth_url = `https://accounts.google.com/o/oauth2/v2/auth?client_id=${client_id}&redirect_uri=${redirect_uri}&response_type=${response_type}&scope=${scope}`; //

  window.location.href = oauth_url; //
};
  </script>
</body>
</html>