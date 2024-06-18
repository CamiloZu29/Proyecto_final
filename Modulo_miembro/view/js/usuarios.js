document.addEventListener("DOMContentLoaded", function() {
    document.querySelector(".nuevaFoto").addEventListener("change", function() {
        var imagen = this.files[0];
        console.log("imagen", imagen["type"]);

        //Validar el tamaño de la imagen

        /*---------------------------------------------
        VALIDAMOS EL FORMATO DE LA IMAGEN SEA JPG O PNG
        ----------------------------------------------*/

        if (imagen["type"] != "image/jpeg" && imagen["type"] != "image/png") {
            this.value = "";
            Swal.fire({
                title: "Error al subir la imagen",
                text: "¡La imagen debe estar en formato JPG o PNG!",
                icon: "error",
                confirmButtonText: "¡Cerrar!"
            });

        /*---------------------------------------------
        VALIDAMOS EL TAMAÑO DE LA IMAGEN, SI ES SUPERIOR MOSTRARA UNA ALERTA
        ----------------------------------------------*/

        } else if (imagen["size"] > 2000000) {
            this.value = "";
            Swal.fire({
                title: "Error al subir la imagen",
                text: "¡La imagen no debe pesar más de 2MB!",
                icon: "error",
                confirmButtonText: "¡Cerrar!"
            });
        } else {
            var datosImagen = new FileReader();
            datosImagen.readAsDataURL(imagen);
            datosImagen.onload = function(event) {
                var rutaImagen = event.target.result;
                var profilePictureDiv = document.querySelector(".profile-picture");
                var existingImg = profilePictureDiv.querySelector("img");
                if (existingImg) {
                    existingImg.src = rutaImagen;
                } else {
                    var imgElement = document.createElement("img");
                    imgElement.src = rutaImagen;
                    imgElement.classList.add("previsualizar");
                    profilePictureDiv.appendChild(imgElement);
                }
                document.querySelector(".profile-picture svg").style.display = "none";
            };
        }
    });
});