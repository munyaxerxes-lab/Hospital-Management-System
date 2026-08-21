<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard</title>
   
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('admin/main.css') }}">

        
    <!-- Remix Icons -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.6.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>

<body>

    <div class="dashboard">
        <div class="aside">
             @include('admin_layout.sidebar')
        </div>
       <div class="main">
             @include('admin_layout.main')
       </div>
       
    </div>

    <footer class="site-footer">
  <div class="footer-container">
    <!-- Column 1: Brand / Info -->
   

    <!-- Column 2: Quick Links -->
    <div class="footer-col">
      <h4>Product</h4>
      <ul>
        <li><a href="#">Features</a></li>
        <li><a href="#">Pricing</a></li>
        <li><a href="#">Updates</a></li>
      </ul>
    </div>

    <!-- Column 3: Resources -->
    <div class="footer-col">
      <h4>Resources</h4>
      <ul>
        <li><a href="#">Documentation</a></li>
        <li><a href="#">Guides</a></li>
        <li><a href="#">Support</a></li>
      </ul>
    </div>

    <!-- Column 4: Legal -->
    <div class="footer-col">
      <h4>Company</h4>
      <ul>
        <li><a href="#">About Us</a></li>
        <li><a href="#">Privacy Policy</a></li>
        <li><a href="#">Terms of Service</a></li>
      </ul>
    </div>
  </div>

  <!-- Bottom Bar -->
  <div class="footer-bottom">
    <p>&copy; 2026 MyProject. All rights reserved.</p>
  </div>
</footer>

</body>

</html>