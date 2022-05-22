function DeleteUser(id) {
  var conf = confirm("¿Está seguro, realmente desea eliminar el registro?");
  if (conf == true) {
    var id = id;
    $.ajax({
      type: "POST",
      url: "accion/abmtabla.php",
      data: {
        id: id,
        accion: "borrar",
      },
      success: function (result) {
        var row = $("#tr" + id);
        $("#tr" + id).remove();
      },
      error: function (result) {
        console.log("error");
      },
    });
  }
}

function EditUserviejo(id) {
  var id = id;
  $("#guardarModal").hide();
  $("#editarModal").show();
  $("#inputid").show();
  $("#labelID").show();

  $.ajax({
    type: "POST",
    url: "ftabla_editar.php",
    data: {
      id: id,
    },
    success: function (data) {
      resultado = JSON.parse(data);
      $("#inputid").val(id);
      $("#inputdescripcion").val(resultado.desc);
      $("#editarModal").attr("onClick", "Editar('" + id + "');");
    },
    error: function (result) {
      console.log("error");
    },
  });
}

function Editar(id) {
  var id = id;
  var descript = $("#inputdescripcion").val();
  $.ajax({
    type: "POST",
    url: "accion/abmtabla.php",
    data: {
      descript: descript,
      accion: "editar",
      id: $("#inputid").val(),
    },
    success: function (result) {
      $("#exampleModal").modal("hide");
      $("#tablaDesc" + id).html(descript);
    },
    error: function (result) {
      console.log("error");
    },
  });
}

function nuevo() {
  $("#inputdescripcion").val("");
  $("#inputid").hide();
  $("#editarModal").hide();
  $("#labelID").hide();
  $("#guardarModal").show();
  // $('#btncargarNuevo').show();
  // $('#desc').show();
  // $('#inputid').val('s');
}

function cargarNuevo() {
  // alert($('#desc').val());
  var descript = $("#inputdescripcion").val();
  $.ajax({
    type: "POST",
    url: "accion/abmtabla.php",
    data: {
      descript: descript,
      accion: "nuevo",
    },
    success: function (result) {
      $("#exampleModal").modal("hide");
      resultado = JSON.parse(result);
      id = resultado.id;
      $("#tablaDesc" + id).html(descript);
      $("#tablaDesc").html(descript);
      var contendor = $("#tabletr").html();
      $("#tablaDesc").html(
        contendor + "<tr><td>" + $("#desc").val() + "</td></tr>"
      );
      var htmlTags =
        '<tr id="tr' +
        id +
        '">' +
        "<td>" +
        id +
        "</td>" +
        '<td id="tablaDesc' +
        id +
        '">' +
        descript +
        "</td>" +
        "<td>" +
        '<button class="btn btn-danger" onclick="DeleteUser(' +
        id +
        ')">B</button>' +
        '<button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="EditUser(' +
        id +
        ')">E</button>' +
        "</td>" +
        "</tr>";

      $("#tbody").append(htmlTags);
    },
    error: function (result) {
      console.log("error");
    },
  });
}

// Funciones usuarios
function nuevoUser() {
  $("#inputdescripcion").val("");
  $("#inputusid").hide();
  $("#labeluserid").hide();
  $("#editarus").hide();
  $("#crearus").show();
}

function cargarUsNuevo() {
  var usnombre = $("#inputusnombre").val();
  var uspass = $("#inputuspass").val();
  var usmail = $("#inputusmail").val();
  var usdeshabilitado = $("#inputdeshabilitado").val();

  $.ajax({
    type: "POST",
    url: "accion/accionUsuario.php",
    data: {
      usnombre: usnombre,
      uspass: uspass,
      usmail: usmail,
      usdeshabilitado: usdeshabilitado,
      accion: "nuevo",
    },
    success: function (result) {
      var fecha = "";
      if (usdeshabilitado == 2) {
        fecha = resultado.fecha;
      }

      $("#modalUser").modal("hide");
      resultado = JSON.parse(result);
      id = resultado.id;
      var contendor = $("#tbodyuser").html();
      $("#tablaDesc").html(
        contendor + "<tr><td>" + $("#desc").val() + "</td></tr>"
      );
      var htmlTags =
        '<tr id="trUser' +
        id +
        '">' +
        "<td>" +
        id +
        "</td>" +
        '<td id="tablaiduser' +
        id +
        '">' +
        resultado.UsNombre +
        "</td>" +
        '<td id="tablapassuser' +
        id +
        '">' +
        resultado.UsPass +
        "</td>" +
        '<td id="tablamailuser' +
        id +
        '">' +
        resultado.UsMail +
        "</td>" +
        '<td id="tablaestadouser' +
        id +
        '">' +
        fecha +
        "</td>" +
        "<td>" +
        '<button class="btn btn-danger" onclick="DeleteUser(' +
        id +
        ')">' +
        '<i class="bi bi-trash"></i>' +
        "</button>" +
        '<button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="EditUser(' +
        id +
        ')">' +
        '<i class="bi bi-pencil"></i>' +
        "</button>" +
        "</td>" +
        "</tr>";
      $("#tbodyuser").append(htmlTags);

      Swal.fire({
        position: "top-end",
        type: "success",
        title: "Usuario creado exitosamente",
        showConfirmButton: false,
        timer: 1500,
      });
    },
    error: function (result) {
      console.log("error");
    },
  });
}

function abrirmodaleditarUser(id) {
  var id = id;
  $("#guardarModal").hide();
  $("#crearus").hide();
  $("#editarModal").show();
  $("#inputid").show();
  $("#labelID").show();

  $.ajax({
    type: "POST",
    url: "accion/accionUsuario.php",
    data: {
      idusuario: id,
      accion: "consultar",
    },
    success: function (data) {
      resultado = JSON.parse(data);
      $("#inputusid").val(id);
      $("#inputusnombre").val(resultado.UsNombre);
      $("#inputuspass").val(resultado.UsPass);
      $("#inputusmail").val(resultado.UsMail);
      $("#inputdeshabilitado").val(resultado.estado);
      $("#editarus").attr("onClick", "editarus('" + id + "');");
    },
    error: function (result) {
      console.log("error");
    },
  });
}

function mouseDown() {
  document.getElementById("inputuspass").type = "text";
  // $("#inputusid").type = "text";
}

function mouseUp() {
  document.getElementById("inputuspass").type = "password";
}

function editarus(id) {
  var usnombre = $("#inputusnombre").val();
  var uspass = $("#inputuspass").val();
  var usmail = $("#inputusmail").val();
  var usdeshabilitado = $("#inputdeshabilitado").val();

  $.ajax({
    type: "POST",
    url: "accion/accionUsuario.php",
    data: {
      usnombre: usnombre,
      uspass: uspass,
      usmail: usmail,
      usdeshabilitado: usdeshabilitado,
      accion: "editar",
      idusuario: $("#inputusid").val(),
    },
    success: function (result) {
      resultado = JSON.parse(result);
      console.log(resultado);
      $("#modalUser").modal("hide");
      $("#tablaiduser" + id).html(resultado.UsNombre);
      $("#inputusnombre" + id).html(resultado.UsNombre);
      $("#tablapassuser" + id).html(resultado.uspass);
      $("#tablamailuser" + id).html(resultado.UsMail);
      if (usdeshabilitado == 1) {
        $("#tablaestadouser" + id).html("");
      } else {
        $("#tablaestadouser" + id).html(resultado.fecha);
      }
      Swal.fire({
        position: "top-end",
        type: "success",
        title: "Usuario editado exitosamente",
        showConfirmButton: false,
        timer: 1500,
      });
    },
    error: function (result) {
      console.log("error");
    },
  });
}

function borraus(id) {
  Swal.fire({
    title: "¿Está seguro?",
    text: " ¿Realmente desea vaciar el carrito?",
    type: "question",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, Eliminar!",
    cancelButtonText: "Cancelar",
  }).then((result) => {
    if (result.value) {
      $.ajax({
        type: "POST",
        url: "accion/accionUsuario.php",
        data: {
          idusuario: id,
          accion: "borrar",
        },
        success: function (result) {
          // var row = $("#trUser" + id);
          $("#trUser" + id).remove();
          console.log(id);
          Swal.fire({
            position: "top-end",
            type: "success",
            title: "Usuario eliminado exitosamente",
            showConfirmButton: false,
            timer: 1500,
          });
        },
        error: function (result) {
          console.log("error");
        },
      });
    }
  });
  // Swal.fire({
  //     title: '¿Está seguro?',
  //     text: " ¿Realmente desea eliminar este usuario?",
  //     type: 'question',
  //     showCancelButton: true,
  //     confirmButtonColor: '#3085d6',
  //     cancelButtonColor: '#d33',
  //     confirmButtonText: 'Si, Eliminar!',
  //     cancelButtonText: 'Cancelar'
  // }).then((result) => {
  //     if (result.isConfirmed) {
  //         $.ajax({
  //             type: "POST",
  //             url: "accion/accionUsuario.php",
  //             data: {
  //                 idusuario: id,
  //                 accion: 'borrar'
  //             },
  //             success: function (result) {
  //                 // var row = $("#trUser" + id);
  //                 $("#trUser" + id).remove();
  //                 console.log(id);
  //                 Swal.fire({
  //                     position: 'top-end',
  //                     type: 'success',
  //                     title: 'Usuario eliminado exitosamente',
  //                     showConfirmButton: false,
  //                     timer: 1500
  //                 })
  //             },
  //             error: function (result) {
  //                 console.log('error');
  //             }
  //         });
  //     }
  // })
}
$(document).ready(function () {
  $("#buscarUsuarioAjax").keyup(function () {
    var busqueda = $("#buscarUsuarioAjax").val();
    // console.log(busqueda);
    $.ajax({
      type: "POST",
      url: "accion/accionUsuario.php",
      data: {
        busqueda: busqueda,
        accion: "buscar",
      },
      success: function (result) {
        resultado = JSON.parse(result);
        $("td").remove();
        var contendor = $("#tbodyuser").html("");
        resultado.forEach(function (persona, index) {
          var fecha = "";
          if (persona.UsDeshabilitado != null) {
            fecha = persona.UsDeshabilitado;
          }
          $("#modalUser").modal("hide");
          resultado = JSON.parse(result);
          id = persona.id;
          console.log(contendor);
          $("#tablaDesc").html(
            contendor + "<tr><td>" + $("#desc").val() + "</td></tr>"
          );
          var htmlTags =
            '<tr id="trUser' +
            id +
            '">' +
            "<td>" +
            id +
            "</td>" +
            '<td id="tablaiduser' +
            id +
            '">' +
            persona.nombre +
            "</td>" +
            '<td id="tablapassuser' +
            id +
            '">' +
            persona.UsPass +
            "</td>" +
            '<td id="tablamailuser' +
            id +
            '">' +
            persona.UsMail +
            "</td>" +
            '<td id="tablaestadouser' +
            id +
            '">' +
            fecha +
            "</td>" +
            "<td>" +
            '<button class="btn btn-danger" onclick="borraus(' +
            id +
            ')">' +
            '<i class="bi bi-trash"></i>' +
            "</button>" +
            '<button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#modalUser" onclick="abrirmodaleditarUser(' +
            id +
            ')">' +
            '<i class="bi bi-pencil"></i>' +
            "</button>" +
            "</td>" +
            "</tr>";
          $("#tbodyuser").append(htmlTags);
        });
      },
    });
  });
});
// Fin Funciones usuario

// inicio Funciones rol
function nuevoRol() {
  $("#inputroldescripcion").val();
  $("#editarrol").hide();
  $("#inputrolid").hide();
  $("#labeluserrol").hide();
  $("#crearrol").show();
}

function cargarrolNuevo() {
  var rodescripcion = $("#inputroldescripcion").val();
  $.ajax({
    type: "POST",
    url: "accion/accionRol.php",
    data: {
      rodescripcion: rodescripcion,
      accion: "nuevo",
    },
    success: function (result) {
      $("#modalRol").modal("hide");
      resultado = JSON.parse(result);
      id = resultado.id;

      var contendor = $("#tbodyrol").html();
      $("#tablaDesc").html(
        contendor + "<tr><td>" + $("#desc").val() + "</td></tr>"
      );

      var htmlTags =
        '<tr id="trRol' +
        id +
        '">' +
        '<td id="tablaidrol' +
        id +
        '">' +
        id +
        "</td>" +
        '<td id="tabladescrol' +
        id +
        '">' +
        rodescripcion +
        "</td>" +
        "<td>" +
        '<button class="btn btn-danger" onclick="borrarol(' +
        id +
        ')">' +
        '<i class="bi bi-trash"></i>' +
        "</button>" +
        '<button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="abrirmodaleditarRol(' +
        id +
        ')">' +
        '<i class="bi bi-pencil"></i>' +
        "</button>" +
        "</td>" +
        "</tr>";

      $("#tbodyrol").append(htmlTags);
    },
    error: function (result) {
      console.log("error");
    },
  });
}

function abrirmodaleditarRol(id) {
  var id = id;

  $("#inputroldescripcion").val();
  $("#editarrol").show();
  $("#inputrolid").show();
  $("#labeluserrol").show();
  $("#crearrol").hide();

  $.ajax({
    type: "POST",
    url: "accion/accionRol.php",
    data: {
      idrol: id,
      accion: "consultar",
    },
    success: function (data) {
      resultado = JSON.parse(data);
      $("#inputrolid").val(resultado.IdRol);
      $("#inputroldescripcion").val(resultado.RoDescripcion);
      $("#editarrol").attr("onClick", "editarrol('" + id + "');");
    },
    error: function (result) {
      console.log("error");
    },
  });
}

function editarrol(id) {
  var descripcionRol = $("#inputroldescripcion").val();
  $.ajax({
    type: "POST",
    url: "accion/accionRol.php",
    data: {
      rodescripcion: descripcionRol,
      accion: "editar",
      idrol: $("#inputrolid").val(),
    },
    success: function (result) {
      resultado = JSON.parse(result);
      $("#modalRol").modal("hide");
      $("#tabladescrol" + id).html(descripcionRol);
    },
    error: function (result) {
      console.log("error");
    },
  });
}

function borrarol(id) {
  var conf = confirm("¿Está seguro, realmente desea eliminar el rol?");
  if (conf == true) {
    var id = id;
    $.ajax({
      type: "POST",
      url: "accion/accionRol.php",
      data: {
        idrol: id,
        accion: "borrar",
      },
      success: function (result) {
        var row = $("#trRol" + id);
        $("#trRol" + id).remove();
      },
      error: function (result) {
        console.log("error");
      },
    });
  }
}
// Fin Funciones usuario

// comienza Funciones usuarioRol

function abrirmodaleditarUsuarioRol(id) {
  var id = id;
  $("#guardarModal").hide();
  $("#crearus").hide();
  $("#editarModal").show();
  $("#inputid").show();
  $("#labelID").show();
  $("#inputusid").val(id);
  $("#inputusnombre").val("");
  $("#inputuspass").val("");
  $("#inputusmail").val("");
  $(":checkbox").prop("checked", false);
  $("#editarusuarioRol").attr("onClick", "guardarusuarioRol('" + id + "');");
  $.ajax({
    type: "POST",
    url: "accion/accionUsuarioRol.php",
    data: {
      idusuario: id,
      accion: "consultar",
    },
    success: function (result) {
      console.log(result);
      resultado = JSON.parse(result);
      $("#inputusnombre").val(resultado.UsNombre);
      $("#inputuspass").val(resultado.UsPass);
      $("#inputusmail").val(resultado.UsMail);
      for (let i = 0; i < resultado.roles.length; i++) {
        $("#checkRoles" + resultado.roles[i]).prop("checked", true);
      }
    },
    error: function (result) {
      console.log("error");
    },
  });
}

function guardarusuarioRol(id) {
  // elimina los roles
  $("input[type=checkbox]").each(function () {
    console.log("borra" + $(this).val());
    $.ajax({
      type: "POST",
      url: "accion/accionUsuarioRol.php",
      async: false,
      data: {
        idusuario: id,
        idrol: $(this).val(),
        accion: "borrar",
      },
      success: function (result) {},
      error: function (result) {},
    });
  });
  insertarUsuarioRol(id);
}

function insertarUsuarioRol(id) {
  $("#tabladescuseRol" + id).html("");

  // carga los seleccionados
  $("input[type=checkbox]:checked").each(function () {
    console.log("emtro " + $(this).val());
    $.ajax({
      type: "POST",
      url: "accion/accionUsuarioRol.php",
      data: {
        idusuario: id,
        idrol: $(this).val(),
        accion: "nuevo",
      },
      success: function (result) {
        resultado = JSON.parse(result);
        $("#tabladescuseRol" + id).html(
          $("#tabladescuseRol" + id).html() + " " + resultado.rol
        );
        Swal.fire({
          position: "top-end",
          type: "success",
          title: "Rol editado exitosamente",
          showConfirmButton: false,
          timer: 1500,
        });
      },
      error: function (result) {
        console.log("error");
      },
    });
  });

  $("#modalUserRol").modal("hide");
}
// Fin Funciones usuarioRol

// Funciones login

function btnLogin() {
  $.ajax({
    type: "POST",
    url: "accion/accionLogin.php",
    data: {
      uspass: $("#uspass").val(),
      usnombre: $("#usnombre").val(),
      accion: "iniciar",
    },
    success: function (result) {
      resultado = JSON.parse(result);
      if (resultado.respuesta == "activa") {
        location.replace("inicio.php");
      } else {
        if (resultado.respuesta == "error") {
          Swal.fire("Error!", "Usuario o contraseña incorrectos", "warning");
        } else if (resultado.respuesta == "sinRol") {
          Swal.fire("Error!", "Usuario sin rol asignado", "warning");
        } else {
          Swal.fire(
            "Error!",
            "Usuario inactivo desde " + resultado.respuesta,
            "warning"
          );
        }
      }
    },
    error: function (result) {
      console.log("error");
    },
  });
}

function cerrarSesion() {
  $.ajax({
    type: "POST",
    url: "accion/accionLogin.php",
    data: {
      // uspass: $('#uspass').val(),
      accion: "cerrar",
    },
    success: function (result) {
      window.location.href = "http://localhost/pdo/vista/login.php";
    },
    error: function (result) {
      console.log("error");
    },
  });
}
// Fin Funciones login

// Funciones rol
function cambioRol($idRol) {
  $.ajax({
    type: "POST",
    url: "accion/accionCambioRol.php",
    data: {
      idrol: $idRol,
      // accion: 'consultar'
    },
    success: function (data) {
      // resultado = JSON.parse(data);
      // $("#inputrolid").val(resultado.IdRol);
      // $("#inputroldescripcion").val(resultado.RoDescripcion);
      // $('#editarrol').attr("onClick", "editarrol('" + id + "');");
      // window.location.href = "http://localhost/pdo/vista/inicio.php";
    },
    error: function (result) {
      console.log("error");
    },
  });
}
// Fin Funciones rol

// Funciones productos

$(document).ready(function (e) {
  $("#fupForm").on("submit", function (e) {
    e.preventDefault();
    $.ajax({
      type: "POST",
      url: "accion/accionProducto.php",
      data: new FormData(this),
      contentType: false,
      cache: false,
      processData: false,
      success: function (result) {
        resultado = JSON.parse(result);
        id = resultado.idproducto;
        if (resultado.prodes == 1) {
          valor1 = "habilitado";
          valor2 = "deshabilitado";
        } else {
          valor1 = "deshabilitado";
          valor2 = "habilitado";
        }
        $("#modalprod").modal("hide");
        var contendor = $("#tbodyprod").html();
        $("#tablaDesc").html(
          contendor + "<tr><td>" + $("#desc").val() + "</td></tr>"
        );
        var htmlTags =
          '<tr id="trprod' +
          id +
          '">' +
          "<td>" +
          id +
          "</td>" +
          '<td id="tablaautorprod' +
          id +
          '">' +
          resultado.pronombre +
          "</td>" +
          '<td id="tablaautorprod' +
          id +
          '">' +
          resultado.proautor +
          "</td>" +
          '<td id="tablastockprod' +
          id +
          '">' +
          resultado.procantstock +
          "</td>" +
          '<td id="tablaeditorialprod' +
          id +
          '">' +
          resultado.proeditorial +
          "</td>" +
          '<td id="tablahabilitadoprod' +
          id +
          '">' +
          '<select class="form-select form-select-sm" aria-label="" onchange="cambiarEstadoProducto(1,' +
          id +
          ')">' +
          '<option selected="">' +
          valor1 +
          "</option>" +
          '<option value="0">' +
          valor2 +
          "</option>" +
          "</select> </td>" +
          "<td>" +
          '<button class="btn btn-danger" onclick="borraProd(\'' +
          id +
          "')\">" +
          '<i class="bi bi-trash"></i>' +
          "</button>" +
          '<button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#modalprod2" onclick="abrirmodaleditarprod(\'' +
          id +
          "')\">" +
          '<i class="bi bi-pencil"></i>' +
          "</button>" +
          "</td>" +
          "</tr>";

        $("#tbodyprod").append(htmlTags);
        Swal.fire({
          position: "top-end",
          type: "success",
          title: "Producto creado exitosamente",
          showConfirmButton: false,
          timer: 1500,
        });
      },
    });
  });
  //editar prodructo formulario
  $("#fupForm2").on("submit", function (e) {
    e.preventDefault();
    $.ajax({
      type: "POST",
      url: "accion/accionProducto.php",
      data: new FormData(this),
      contentType: false,
      cache: false,
      processData: false,
      success: function (result) {
        console.log(result);
        resultado = JSON.parse(result);
        console.log(resultado);
        id = resultado.idproducto;
        if (resultado.prodes == 1) {
          valor1 = "habilitado";
          valor2 = "deshabilitado";
        } else {
          valor1 = "deshabilitado";
          valor2 = "habilitado";
        }
        var contendor = $("#tbodyprod").html();
        $("#tablaDesc").html(
          contendor + "<tr><td>" + $("#desc").val() + "</td></tr>"
        );
        var htmlTags =
          //'<tr id="trprod' + id + '">' +
          "<td>" +
          id +
          "</td>" +
          '<td id="tablaautorprod' +
          id +
          '">' +
          resultado.pronombre +
          "</td>" +
          '<td id="tablaautorprod' +
          id +
          '">' +
          resultado.proautor +
          "</td>" +
          '<td id="tablastockprod' +
          id +
          '">' +
          resultado.procantstock +
          "</td>" +
          '<td id="tablaeditorialprod' +
          id +
          '">' +
          resultado.proeditorial +
          "</td>" +
          '<td id="tablahabilitadoprod' +
          id +
          '">' +
          '<select class="form-select form-select-sm" aria-label="" onchange="cambiarEstadoProducto(1,' +
          id +
          ')">' +
          '<option selected="">' +
          valor1 +
          "</option>" +
          '<option value="0">' +
          valor2 +
          "</option>" +
          "</select> </td>" +
          "<td>" +
          '<button class="btn btn-danger" onclick="borraProd(\'' +
          id +
          "')\">" +
          '<i class="bi bi-trash"></i>' +
          "</button>" +
          '<button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#modalprod2" onclick="abrirmodaleditarprod(\'' +
          id +
          "')\">" +
          '<i class="bi bi-pencil"></i>' +
          "</button>" +
          "</td>" +
          $("#trprod" + id).empty();
        $("#trprod" + id).append(htmlTags);
        $("#modalprod2").modal("hide");
        Swal.fire({
          position: "top-end",
          type: "success",
          title: "Producto editado exitosamente",
          showConfirmButton: false,
          timer: 1500,
        });
      },
    });
  });
});
//file type validation
$("#file").change(function () {
  var file = this.files[0];
  var imagefile = file.type;
  var match = ["image/jpeg", "image/png", "image/jpg"];
  if (
    !(imagefile == match[0] || imagefile == match[1] || imagefile == match[2])
  ) {
    alert("Please select a valid image file (JPEG/JPG/PNG).");
    $("#file").val("");
    return false;
  }
});
$(document).ready(function () {
  $("#idmantenerfotoInput").change(function () {
    // alert( '$( "#unaimagenedit" ).prop()')
    if (!$("#unaimagenedit").is(":disabled")) {
      $("#unaimagenedit").prop("disabled", true);
    } else {
      $("#unaimagenedit").prop("disabled", false);
    }
  });
});

function borraProd(id) {
  var conf = confirm("¿Está seguro, realmente desea eliminar el producto?");
  if (conf == true) {
    var id = id;
    $.ajax({
      type: "POST",
      url: "accion/accionProducto.php",
      data: {
        idproducto: id,
        accion: "borrar",
      },
      success: function (result) {
        var row = $("#trprod" + id);
        $("#trprod" + id).remove();
      },
      error: function (result) {
        console.log("error");
      },
    });
  }
}
function abrirmodaleditarprod(id) {
  var id = id;
  $("#btnGuardarProd").hide();
  $("#btnEditarProd").show();

  $.ajax({
    type: "POST",
    url: "accion/accionProducto.php",
    data: {
      idproducto: id,
      accion: "consultar",
      accionId: "2",
    },
    success: function (data) {
      resultado = JSON.parse(data);
      $("#idproductoedit").val(resultado.idproducto);
      $("#pronombreedit").val(resultado.pronombre);
      $("#proprecioedit").val(resultado.proprecio);
      $("#proautoredit").val(resultado.proautor);
      $("#proanioedit").val(resultado.proanio);
      $("#procantstockedit").val(resultado.procantstock);
      $("#proeditorialedit").val(resultado.proeditorial);
      $("#prodetalleedit").val(resultado.prodetalle);
      $("#idprodeshabilitadoedit").val(resultado.prodes);
    },
    error: function (result) {
      console.log("error");
    },
  });
}

function editarprod(id) {
  //     var descripcionRol = $('#inputroldescripcion').val();
  var id = id;
  var proanio = $("#proanio").val();
  var proautor = $("#proautor").val();
  var proprecio = $("#proprecio").val();
  var pronombre = $("#pronombre").val();
  var prodetalle = $("#prodetalle").val();
  var proeditorial = $("#proeditorial").val();
  var procantstock = $("#procantstock").val();
  $.ajax({
    type: "POST",
    url: "accion/accionProducto.php",
    data: {
      proanio: proanio,
      proautor: proautor,
      proprecio: proprecio,
      pronombre: pronombre,
      prodetalle: prodetalle,
      proeditorial: proeditorial,
      procantstock: procantstock,
      idproducto: id,
      accion: "editar",
    },
    success: function (result) {
      resultado = JSON.parse(result);
      $("#modalprod").modal("hide");
      $("#tablaDesc" + id).html(descripcionRol);
    },
    error: function (result) {
      console.log("error");
    },
  });
}
function limpiarFormulario() {
  $("#pronombre").val("");
  $("#proprecio").val("");
  $("#proautor").val("");
  $("#proanio").val("");
  $("#procantstock").val("");
  $("#proeditorial").val("");
  $("#prodetalle").val("");
  $("#unaimagen").val("");
}

function AgregarProd(id, precio) {
  $.ajax({
    type: "POST",
    url: "accion/accionCarrito.php",
    data: {
      idproducto: id,
      productoprecio: precio,
      accion: "agregar",
      cantProd: 1,
    },
    success: function (result) {
      $("#btnAgregar" + id).prop("disabled", true);
      const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 2000,
      });

      Toast.fire({
        type: "success",
        title: "Producto agregado al carrito",
      });
    },
    error: function (result) {
      console.log("error");
    },
  });
}

function incrementarProd(stockMax, id, valor) {
  $.ajax({
    type: "POST",
    url: "accion/accionCarrito.php",
    data: {
      id: id,
      stockMax: stockMax,
      accion: "incrementar",
      valor: parseFloat(valor),
    },
    success: function (result) {
      var x = $("#inputstockCarrito" + id).val();
      suma = parseFloat(x) + parseFloat(1);
      $("#inputstockCarrito" + id).val(suma);
      if (suma >= stockMax) {
        $("#btnIncrementar" + id).prop("disabled", true);
      }
      if (suma > 0) {
        $("#btnDisminuir" + id).prop("disabled", false);
      }
      $("#total" + id).text(parseFloat(valor) * parseFloat(suma));
      var total = parseFloat(valor) + parseFloat($("#idTotalCarrito").text());
      $("#idTotalCarrito").html("<b>" + total + "</b>");
    },
    error: function (result) {
      console.log("error");
    },
  });
}

function disminuirProd(stockMax, id, valor) {
  $.ajax({
    type: "POST",
    url: "accion/accionCarrito.php",
    data: {
      id: id,
      stockMax: stockMax,
      accion: "disminuir",
      valor: parseFloat(valor),
    },
    success: function (result) {
      var x = $("#inputstockCarrito" + id).val();
      suma = parseFloat(x) - parseFloat(1);
      $("#inputstockCarrito" + id).val(suma);
      if (suma < parseFloat(2)) {
        $("#btnDisminuir" + id).prop("disabled", true);
      }
      if (suma < stockMax) {
        $("#btnIncrementar" + id).prop("disabled", false);
      }
      $("#total" + id).text(parseFloat(valor) * parseFloat(suma));
      var total = parseFloat($("#idTotalCarrito").text() - parseFloat(valor));
      $("#idTotalCarrito").html("<b>" + total + "</b>");
    },
    error: function (result) {
      console.log("error");
    },
  });
}

function vaciarCarro() {
  Swal.fire({
    title: "¿Está seguro?",
    text: " ¿Realmente desea vaciar el carrito?",
    type: "question",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, Eliminar!",
    cancelButtonText: "Cancelar",
  }).then((result) => {
    $.ajax({
      type: "POST",
      url: "accion/accionCarrito.php",
      data: {
        accion: "vaciar",
      },
      success: function (result) {
        $("#alertaCarrito").show();
        $("#tablacarrito").remove();
        $("#botonesCarrito").hide();
        $("#tablacarrito").hide();
        $("#alertaCarrito").html(
          " <div class='alert alert-primary' role='alert'>  El carrito esta vacio <i class='far fa-frown'></i> &nbsp <a href='productosListado.php'></div>"
        );
        Swal.fire({
          type: "success",
          title: "El carrito se vacio con exito",
          showConfirmButton: false,
          timer: 1500, //el tiempo que dura el mensaje en ms
        });
      },
      error: function (result) {
        console.log("error");
      },
    });
  });
}

function borraProdCarrito(id) {
  // var conf = confirm("¿Está seguro, realmente desea eliminar el producto?");
  Swal.fire({
    title: "¿Está seguro?",
    text: " ¿Realmente desea vaciar el producto?",
    type: "question",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, Eliminar!",
    cancelButtonText: "Cancelar",
  }).then((result) => {
    $.ajax({
      type: "POST",
      url: "accion/accionCarrito.php",
      data: {
        id: id,
        accion: "borrar",
      },
      success: function (result) {
        var valor = parseFloat($("#total" + id).text());
        var row = $("#trCarrito" + id);
        $("#trCarrito" + id).remove();
        var total = parseFloat($("#idTotalCarrito").text() - parseFloat(valor));
        $("#idTotalCarrito").html("<b>" + total + "</b>");
        Swal.fire(
          "Eliminado!",
          "El producto fue eliminado exitosamente.",
          "success"
        );
        if (total == 0) {
          $("#botonesCarrito").hide();
          $("#tablacarrito").hide();
          $("#alertaCarrito").html(
            " <div class='alert alert-primary' role='alert'>  El carrito esta vacio <i class='far fa-frown'></i>&nbsp<a href='productosListado.php'></div>"
          );
        }
      },
      error: function (result) {
        console.log("error");
      },
    });
  });
}

// Fin Funciones productos
// Funciones Compra
function ConfirmarCompra() {
  Swal.fire({
    title: "¿Está seguro?",
    text: " ¿Realmente desea finalizar la compra?",
    type: "question",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, Compar!",
    cancelButtonText: "Cancelar",
  }).then((result) => {
    if (result.value) {
      $.ajax({
        type: "POST",
        url: "accion/accionCompra.php",
        data: {
          accion: "confirmar",
        },
        success: function (resulta) {
          resultado = JSON.parse(resulta);
          id = resultado.idcompra;
          Swal.fire({
            position: "top-end",
            type: "success",
            title: "El estado del producto fue modificado",
            showConfirmButton: false,
            timer: 1500,
          });
          window.location.href = "miultimacompra.php?idcompra=" + id;
        },
        error: function (result) {
          console.log("error");
        },
      });
    }
  });
}

function cambiarEstado(IdCompraEstTipo, IdCompraEstado, idcompra) {
  // alert(val);
  $.ajax({
    type: "POST",
    url: "accion/accionCompraEstadoTipo.php",
    data: {
      accion: "editar",
      idcompraestado: IdCompraEstTipo,
      idcompraestadotipo: IdCompraEstado,
      idcompra: idcompra,
    },
    success: function (result) {
      Swal.fire({
        position: "top-end",
        type: "success",
        title: "El estado de la compra fue modificado",
        showConfirmButton: false,
        timer: 1500,
      });
    },
    error: function (result) {
      console.log("error");
    },
  });
}
function cambiarEstadoProducto(prodeshabilitado, idproducto) {
  // alert(prodeshabilitado);
  $.ajax({
    type: "POST",
    url: "accion/accionProducto.php",
    data: {
      accion: "editarEstado",
      prodeshabilitado: prodeshabilitado,
      idproducto: idproducto,
    },
    success: function (result) {
      Swal.fire({
        position: "top-end",
        type: "success",
        title: "El estado del producto fue modificado",
        showConfirmButton: false,
        timer: 1500,
      });
    },
    error: function (result) {
      console.log("error");
    },
  });
}

function cambiarRol(idrol) {
  $.ajax({
    type: "POST",
    url: "accion/accionRol.php",
    data: {
      accion: "cambiarRol",
      idrol: idrol,
    },
    success: function (result) {
      Swal.fire({
        position: "top-end",
        type: "success",
        title: "Rol cambiado exitosamente",
        showConfirmButton: false,
        timer: 1500,
      });
      setTimeout(function () {
        // hago un setTimeout para que veas los otros pasos en tu pantalla
        window.location.reload();
      }, 600);
    },
    error: function (result) {
      console.log("error");
    },
  });
}

(function ($bs) {
  const CLASS_NAME = "has-child-dropdown-show";
  $bs.Dropdown.prototype.toggle = (function (_orginal) {
    return function () {
      document.querySelectorAll("." + CLASS_NAME).forEach(function (e) {
        e.classList.remove(CLASS_NAME);
      });
      let dd = this._element
        .closest(".dropdown")
        .parentNode.closest(".dropdown");
      for (; dd && dd !== document; dd = dd.parentNode.closest(".dropdown")) {
        dd.classList.add(CLASS_NAME);
      }
      return _orginal.call(this);
    };
  })($bs.Dropdown.prototype.toggle);

  document.querySelectorAll(".dropdown").forEach(function (dd) {
    dd.addEventListener("hide.bs.dropdown", function (e) {
      if (this.classList.contains(CLASS_NAME)) {
        this.classList.remove(CLASS_NAME);
        e.preventDefault();
      }
      e.stopPropagation(); // do not need pop in multi level mode
    });
  });

  // for hover del menu niveles
  document
    .querySelectorAll(".dropdown-hover, .dropdown-hover-all .dropdown")
    .forEach(function (dd) {
      dd.addEventListener("mouseenter", function (e) {
        let toggle = e.target.querySelector(
          ':scope>[data-bs-toggle="dropdown"]'
        );
        if (!toggle.classList.contains("show")) {
          $bs.Dropdown.getOrCreateInstance(toggle).toggle();
          dd.classList.add(CLASS_NAME);
          $bs.Dropdown.clearMenus();
        }
      });
      dd.addEventListener("mouseleave", function (e) {
        let toggle = e.target.querySelector(
          ':scope>[data-bs-toggle="dropdown"]'
        );
        if (toggle.classList.contains("show")) {
          $bs.Dropdown.getOrCreateInstance(toggle).toggle();
        }
      });
    });
})(bootstrap);

//ADministrador del menu
$(document).ready(function (e) {
  $("#formNuevoMenu").on("submit", function (e) {
    e.preventDefault();
    $.ajax({
      type: "POST",
      url: "accion/accionMenu.php",
      data: new FormData(this),
      contentType: false,
      cache: false,
      processData: false,
      success: function (result) {
        resultado = JSON.parse(result);
        estado = resultado.estado == 1 ? "Habilitado" : "Deshabilitado";
        padre = resultado.idpadre == -1 ? "-" : resultado.idpadre;
        $("#modalMenu").modal("hide");
        id = resultado.idmenu;
        estado = resultado.estado == 1 ? "Habilitado" : "Deshabilitado";
        console.log(resultado);
        // var contendor = $("#tbodymenu").html();
        // $('#tablaDesc').html(contendor + '<tr><td>' + $('#desc').val() + '</td></tr>');
        // var htmlTags = '<tr id="trMenu' + id + '">' +
        //     '<td id="filaidmenu' + id + '">' + id + '</td>' +
        //     '<td id="filanombremenu' + id + '">' + resultado.menombre + '</td>' +
        //     '<td id="filaidpadremenu' + id + '">' + padre + '</td>' +
        //     '<td id="filalinkmenu' + id + '">' + resultado.link + '</td>' +
        //     '<td id="filaestadomenu' + id + '">' + estado + '</td>' +
        //     '<td id="filadescripcionmenu' + id + '">' + resultado.descripcion + '</td>' +
        //     '<td>' +
        //     '<button class="btn btn-danger" onclick="borrarMenu(' + id + ')">' +
        //     '<i class="bi bi-trash"></i>'
        //     + '</button>' +
        //     '<button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#modalMenuEdit" onclick="abrirmodaleditarMenu('+id+')">' +
        //     '<i class="bi bi-pencil"></i>' +
        //     '</button>' +
        //     '</td>' +
        //     '</tr>';

        // $('#tbodymenu').append(htmlTags);
      },
    });
  });

  $("#formEditarMenu").on("submit", function (e) {
    // alert( new FormData(this));
    e.preventDefault();
    $.ajax({
      type: "POST",
      url: "accion/accionMenu.php",
      data: new FormData(this),
      contentType: false,
      cache: false,
      processData: false,
      success: function (result) {
        Swal.fire({
          position: "top-end",
          type: "success",
          title: "Menu editado exitosamente",
          showConfirmButton: false,
          timer: 1500,
        });
        resultado = JSON.parse(result);
        $("#modalMenuEdit").modal("hide");
        id = resultado.idmenu;
        estado = resultado.estado == 1 ? "Habilitado" : "Deshabilitado";
        console.log(id, estado);
        // var contendor = $("#tbodymenu").html();
        // $('#tablaDesc').html(contendor + '<tr><td>' + $('#desc').val() + '</td></tr>');

        // $("#tbodymenu").append(contendor);
        var htmlTags =
          // '<tr id="trMenu' + id + '">' +
          '<td id="filaidmenu' +
          id +
          '">' +
          id +
          "</td>" +
          '<td id="filanombremenu' +
          id +
          '">' +
          resultado.menombre +
          "</td>" +
          '<td id="filaidpadremenu' +
          id +
          '">' +
          resultado.idpadre +
          "</td>" +
          '<td id="filalinkmenu' +
          id +
          '">' +
          resultado.link +
          "</td>" +
          '<td id="filaestadomenu' +
          id +
          '">' +
          estado +
          "</td>" +
          '<td id="filadescripcionmenu' +
          id +
          '">' +
          resultado.descripcion +
          "</td>" +
          "<td>" +
          '<button class="btn btn-danger" onclick="borrarMenu(' +
          id +
          ')">' +
          '<i class="bi bi-trash"></i>' +
          "</button>" +
          '<button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#modalMenuEdit" onclick="abrirmodaleditarMenu(' +
          id +
          ')">' +
          '<i class="bi bi-pencil"></i>' +
          "</button>" +
          "</td>";
        // '</tr>';
        $("#trMenu" + id).empty();
        $("#trMenu" + id).append(htmlTags);
      },
    });
  });
});

function limpiarModal() {
  $("#menombre").val("");
  $("#idpadre").val("");
  $("#linkmenu").val("");
  $("#medescripcion").val("");
  $("#medeshabilitado").val("");
  $("#rolesedit").val();
}

function abrirmodaleditarMenu(id) {
  limpiarModal();
  var id = id;
  $("#menombre").val("");
  $("#idpadre").val("");
  $("#linkmenu").val("");
  $("#medescripcion").val("");
  $("#medeshabilitado").val("");
  $.ajax({
    type: "POST",
    url: "accion/accionMenu.php",
    data: {
      idmenu: id,
      accion: "consultar",
    },
    success: function (data) {
      resultado = JSON.parse(data);
      console.log(resultado);
      $("#idmenuedit").val(resultado.idmenu);
      $("#menombreedit").val(resultado.menombre);
      $("#idpadreedit").val(resultado.idpadre);
      $("#linkmenuedit").val(resultado.link);
      $("#medeshabilitadoedit").val(resultado.estado);
      $("#medescripcionedit").val(resultado.descripcion);
    },
    error: function (result) {
      console.log("error");
    },
  });
}

function borrarMenu(id) {
  var id = id;
  Swal.fire({
    title: "Are you sure?",
    text: "You won't be able to revert this!",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, delete it!",
  }).then((result) => {
    if (result.value) {
      $.ajax({
        type: "POST",
        url: "accion/accionMenu.php",

        data: {
          idmenu: id,
          accion: "borrar",
        },
        success: function (result) {
          $("#trMenu" + id).remove();
          Swal.fire("Deleted!", "Your file has been deleted.", "success");
        },
        error: function (result) {
          console.log("error");
        },
      });
    }
  });
}
