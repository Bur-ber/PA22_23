createAvatar();

function setSelected(ele) {

    let siblings = ele.parentElement.parentElement.children;
    for (var i = 0; i < siblings.length; i++) {
        var sibling = siblings[i];
        sibling.children[0].classList.remove("selected");
    }
    ele.classList.add("selected");
    createAvatar();
}

function createAvatar() {
    eles = document.getElementsByClassName("selected");
    images = "";
    for (let i = 0; i < eles.length; i++) {
        let ele = eles[i];
        images += `<img src=${ele.dataset.img_src} class='avatar-part' />`;
    }
    document.getElementById("avatar-container").innerHTML = images;
}

function saveAvatar() {
    // Create a canvas element
    var canvas = document.createElement("canvas");
    var context = canvas.getContext("2d");

    // Set the canvas size to match the avatar container size
    var avatarContainer = document.getElementById("avatar-container");
    canvas.width = avatarContainer.offsetWidth;
    canvas.height = avatarContainer.offsetHeight;

    // Iterate over each avatar part and draw it on the canvas
    var avatarParts = avatarContainer.getElementsByClassName("avatar-part");
    Array.from(avatarParts).forEach(function (avatarPart) {
        context.drawImage(avatarPart, 0, 0, avatarPart.width, avatarPart.height);
    });

    // Create a temporary link and set the canvas image data as the href
    var link = document.createElement("a");
    link.href = canvas.toDataURL("image/png");
    link.download = "avatar.png";

    // Trigger a click event on the link to start the download
    link.click();
}