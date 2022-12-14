// Delete Admin
function showModelDel(id, email) {
    window.id = id;
    document.getElementById("textModelDel").innerHTML =
        "คุณเเน่ใจที่จะลบผู้ดูเเลระบบ " + email;
    $("#modal-del").modal("show");
}

function confirmDel() {
    document.getElementById("del-admin-form" + window.id).submit();
}

// Add Admin
function showModelAdd() {
    if (document.getElementById("InputAddAdmin").value == "") {
        $("#modal-plese-input").modal("show");
    } else {
        document.getElementById("textModelAdd").innerHTML =
            "คุณเเน่ใจที่จะเพิ่มผู้ดูเเลระบบ " +
            document.getElementById("InputAddAdmin").value;
        $("#modal-add").modal("show");
    }
}

function confirmAdd() {
    document.getElementById("add-admin-form").submit();
}

// Close Model
function closeModel() {
    $("#modal-plese-input").modal("hide");
    $("#modal-del").modal("hide");
    $("#modal-add").modal("hide");
}
