    <div class="headerbar">

        <!-- LOGO -->
        <div class="headerbar-left">
            <a href="index.php" class="logo"><img alt="Logo" src="../assets/images/WAM.png" /></a>
        </div>

        <nav class="navbar-custom">

                    <ul class="list-inline float-right mb-0">

                        <li class="list-inline-item dropdown notif">
                            <a class="nav-link dropdown-toggle nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                <img src="../assets/images/avatars/admin.png" alt="Profile image" class="avatar-rounded">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                                <!-- item-->
                                <div class="dropdown-item noti-title">
                                    <h5 class="text-overflow"><small>Hola, <?php echo $empleado->getNombre(); ?></small> </h5>
                                </div>

                                <!-- item-->
                                <a href="../../FERRETRUPER/assets/php/Controllers/CerrarSesion.php" class="dropdown-item notify-item">
                                    <i class="fa fa-power-off"></i> <span>Cerrar sesión</span>
                                </a>
                                
                            </div>
                        </li>

                    </ul>
                    <?php 
                        if($empleado->getPermiso()==1){
                            ?>
                            <ul class="list-inline menu-left mb-0">
                                <li class="float-left">
                                    <button class="button-menu-mobile open-left">
                                        <i class="fa fa-fw fa-bars"></i>
                                    </button>
                                </li>                        
                            </ul>
                            <?php 
                        }
                     ?>
        </nav>

    </div>