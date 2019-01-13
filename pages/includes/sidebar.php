	<div class="left main-sidebar">
	
		<div class="sidebar-inner leftscroll">

			<div id="sidebar-menu">
        
			<ul>

					<li class="submenu">
						<a <?php if(!strcmp(basename($_SERVER['PHP_SELF']),"index.php")){?> class="active" <?php } ?> href="index.php"><i class="fa fa-fw fa-home"></i><span> Pagina principal</span> </a>
                    </li>
					
					<li class="submenu">
                        <a href="#"><i class="fa fa-fw fa-file"></i> <span> Inventario </span> <span class="menu-arrow"></span></a>
							<ul class="list-unstyled">
								<li><a <?php if(!strcmp(basename($_SERVER['PHP_SELF']),"inventario.php")){?> class="active" <?php } ?> href="inventario.php">Ver inventario</a></li>
								<li><a <?php if(!strcmp(basename($_SERVER['PHP_SELF']),"abastecer.php")){?> class="active" <?php } ?> href="abastecer.php">Abastecer</a></li>
							</ul>
                    </li>

                    <li class="submenu">
                        <a <?php if(!strcmp(basename($_SERVER['PHP_SELF']),"proveedores.php")){?> class="active" <?php } ?> href="proveedores.php"><i class="fa fa-fw fa-user-plus"></i><span> Proveedores </span> </a>
                    </li>

										
                    <li class="submenu">
                        <a href="#"><i class="fa fa-fw fa-shopping-cart"></i> <span> Ventas </span> <span class="menu-arrow"></span></a>
                            <ul class="list-unstyled">
                                <li><a href="#">Ver ventas</a></li>
                                <li><a href="#">Ventas del dia</a></li>
                                <li><a href="#">Garantia</a></li>
                                <li><a href="#">Creditos activos</a></li>
                                <li><a href="#">Anular venta</a></li>
                            </ul>
                    </li>

					<li class="submenu">
                        <a href="#"><i class="fa fa-fw fa-user"></i> <span> Clientes </span> <span class="menu-arrow"></span></a>
                            <ul class="list-unstyled">
                                <li><a <?php if(!strcmp(basename($_SERVER['PHP_SELF']),"clientes.php")){?> class="active" <?php } ?> href="clientes.php">Ver Clientes</a></li>
								<li><a href="#"  id="añadir-cliente" data-target="#añadirCliente" data-toggle="modal">Añadir cliente</a></li>
                            </ul>
                    </li>
					
            </ul>

            <div class="clearfix"></div>

			</div>
        
			<div class="clearfix"></div>

		</div>

	</div>