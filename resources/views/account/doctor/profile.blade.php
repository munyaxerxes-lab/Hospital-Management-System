@extends('doctors-layout.index')
@section('content')
<div class="doc-profile-text"> 
     <h1>Profile</h1>
</div>

   

    
    <container Class="doctor-profile-view">
        
        <!-- Profile Header -->
        <div class="header-section">
        <div class="profile-container">
                    
               

                    <img id="profile-pic" class="profile-img" src="https://placeholder.com" alt="Profile Picture">
        
                <!-- Pen Icon Button -->

                <button id="pen-btn" class="pen-icon" title="Change photo">
        
                </button>
        
                 <!-- Hidden File Input --> 

                    <input type="file" id="file-input" accept="image/*">
                </div>
                 <div class="information">
                        <h2>Doctor Will Smith</h2>
                        <h3>Cardiologist</h3>
                        <button>
                            active
                        </button>
                </div>
                </div>
              

                <!-- Bubble Modal View -->
                <div id="bubble-modal" class="modal">
                    <div class="modal-content">
                    <img id="modal-img" src="https://placeholder.com" alt="Enlarged Profile">

                 <!-------doctor profile page------>
                   

            <script>
                const profilePic = document.getElementById('profile-pic');
                const penBtn = document.getElementById('pen-btn');
                const fileInput = document.getElementById('file-input');
                const modal = document.getElementById('bubble-modal');
                const modalImg = document.getElementById('modal-img');

                // Click profile picture to bubble up/enlarge
                 profilePic.addEventListener('click', () => {
                 modalImg.src = profilePic.src;
                 modal.style.display = 'flex';
                 });

                    // Click outside the image to close the modal bubble
                modal.addEventListener('click', () => {
                modal.style.display = 'none';
                });

                    // Click pen icon to open file explorer
                penBtn.addEventListener('click', (e) => {
                e.stopPropagation(); // Prevent opening the image bubble modal
                fileInput.click();
                });

                    // Change profile picture upon file selection
                fileInput.addEventListener('change', (event) => {
                const file = event.target.files[0];
                if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    profilePic.src = e.target.result;
                }
                reader.readAsDataURL(file);
                }
                });
            </script>~
        </div>

        
                <div class="avatar-info">
    
                    <h1>Dr. Karim Kouam</h1>
    
                    <h2>Cardiology</h2>
    
                    <h3>Active</h3>
    
                </div>
        </div>
        
        
        
        
        <!-- Doctor Information -->
        
        <div class="doctor-info">
            
            <table>
                
                <tr>
                    
                    <td>
                        
                        <solid>Professional Qualifications</solid><br>
                        <strong>MD, FWACS Cardiology</stong>
                            
                            
                        </td>
                        
                        <td>

                                <solid>Years of Experience</solid><br>

                                <strong>12 Years</strong>

                        </td>

                    </tr>

                    <tr>

                        <td>

                                <solid>Consultation Fees</solid><br>

                                <strong>15,000 XAF</strong>

                        </td>

                        <td>

                                <solid>Phone Number</solid><br>

                                <strong>+237 677 12 34 56</strong>

                        </td>

                    </tr>

                    <tr>

                        <td>

                                <solid>Email Address</solid><br>

                                <strong>k.kouam@jclinic.cm</strong>

                        </td>

                    </tr>

            </table>
        </div>
        
    </container>    

         
@endsection