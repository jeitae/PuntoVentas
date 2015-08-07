# PuntoVentas

# Universidad de Costa Rica
# Oficina de TCU 2015
# Recinto de Guápiles

# Detalles del Sistema

# El siguiente proyecto tiene el propósito de 
# colaborar con las PYMES de la zona de Pococí.

# Este proyecto de Punto de Ventas está basado en
# un Sistema de Punto de Ventas de código abierto
# con el objetivo de simplificar la labor de 
# implementación y creación del mismo.

# El Sistema utiliza una metodología de programación
# por Sprints o ciclos de desarrollo por etapas, está
# basado en el Modelo de Vista Controlador lo mayor 
# posible.

# Cuenta con una clase de conexión de datos, y cada
# modulo separado por su función dentro de la carpeta
# includes la cual tiene el papel de separar los 
# componentes necesarios de estos.

# La presente aplicación controla el ingreso al 
# sistema mediante la implementación de Roles de
# acceso, donde su principal utilidad está enfocada 
# en la Facturación de productos de la empresa. Ofrece
# un control de facturas pendientes y muestra el detalle
# de las facturas pagadas. Tanto el administrador 
# del Sistema como un usuario estándar (Vendedor), 
# tienen la capacidad de realizar venta de artículos.

# Solamente el Administrador posee el derecho de 
# realizar todas las demás funciones del sistema
# como: Optimizar el sistema, descargar informes,
# administrar los usuarios, ver el cierre de caja,
# administrar el inventario y los proveedores,
# entre otros.

# Este proyecto implemente librerías externas para
# el uso del calendario, calculadora y creación del
# código de barras de los artículos del inventario.

# Además el sistema maneja el acceso prohibido a través
# de las subcarpetas, mostrando al usuario no autorizado
# que se encuentra en una zona restringida.

# -------------------------------------------------

# Configuración del Sistema

# En la carpeta INCLUDES/SYS, se encuentra el archivo
# "conexion.php" donde se pueden modificar los parámetros
# de acceso a la base de datos, también se incluye una
# carpeta con los scripts de creación de la misma.
