
document.addEventListener('DOMContentLoaded', function() {
    const menuButton = document.getElementById('menu-button');
    const menu = document.getElementById('menu');
  });
  
  
  menuButton.addEventListener('click', function() {
       
    if (menu.classList.contains('show'))
      {menu.classList.remove('show');}
    else{menu.classList.add('show');}
  });
  