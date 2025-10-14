
// mobile toggle navbar
const btn = document.getElementById('menu-btn');
    const menu = document.getElementById('mobile-menu');

    btn.addEventListener('click', () => {
      menu.classList.toggle('hidden');
    });

    const dropdownBtn = document.getElementById('dropdown-btn');
    const dropdownMenu = document.getElementById('dropdown-menu');

    dropdownBtn.addEventListener('click', () => {
      dropdownMenu.classList.toggle('hidden');
    });


      document.querySelectorAll(".faq-item").forEach(item => {
    item.addEventListener("click", () => {
      const content = item.querySelector("p");
      const icon = item.querySelector("i");

      content.classList.toggle("hidden");
      icon.classList.toggle("fa-plus");
      icon.classList.toggle("fa-minus");
    });
  });



  // rescue dropdownBtn

  const menuBtn = document.getElementById("menu-btn");
  const mobileMenu = document.getElementById("mobile-menu");
  menuBtn.addEventListener("click", () => {
    mobileMenu.classList.toggle("hidden");
  });


  //clinic counter
