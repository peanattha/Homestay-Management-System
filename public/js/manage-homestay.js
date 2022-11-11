// Delete homestay Type
function showModelDelhomestayType(id, homestay_type_name) {
    window.id_homestay_type = id;
    document.getElementById("textModelDelhomestayType").innerHTML =
        "คุณเเน่ใจที่จะลบประเภทที่พัก " + homestay_type_name;
    $("#modal-del-homestay-type").modal("show");
}
function confirmDelhomestayType() {
    document.getElementById("del-homestay-type" + window.id_homestay_type).submit();
}

// Edit homestay Type
function showModelEdithomestayType(id, homestay_type_name) {
    var name = $("#edit-homestay-type");
    name.val(homestay_type_name);

    var edit_homestay_type_id = $("#edit-homestay-type-id");
    edit_homestay_type_id.val(id);

    $("#modelEdithomestayType").modal("show");
}

// Add homestay Type
function showModelAddhomestayType(id, email) {
    if (document.getElementById("homestay_type_name").value == "") {
        document.getElementById("textModelPleseInput").innerHTML =
            "กรุณากรอกประเภทที่พัก ที่ต้องการเพิ่ม";
        $("#modal-plese-input").modal("show");
    } else {
        document.getElementById("textModelAddhomestayType").innerHTML =
            "คุณเเน่ใจที่จะเพิ่มประเภทที่พัก " +
            document.getElementById("homestay_type_name").value;
        $("#modal-add-homestay-type").modal("show");
    }
}
function confirmAddhomestayType() {
    document.getElementById("add-homestay-type").submit();
}

// Delete homestay
function showModelDelhomestay(id, name) {
    window.id_homestay = id;
    document.getElementById("textModelDelhomestay").innerHTML =
        "คุณเเน่ใจที่จะลบ " + name;
    $("#modal-del-homestay").modal("show");
}

function confirmDelhomestay() {
    document.getElementById("del-homestay" + window.id_homestay).submit();
}

//Close Model
function closeModel() {
    $("#modal-plese-input").modal("hide");
    $("#modal-del-homestay-type").modal("hide");
    $("#sameName").modal("hide");
    $("#modal-del-homestay").modal("hide");
    $("#modelEdithomestayType").modal("hide");
    $("#modal-add-homestay-type").modal("hide");
    $('#modal-search-none').modal('hide');
}
