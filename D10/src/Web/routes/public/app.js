/** @type HTMLInputElement */
const fileInput = document.getElementById("file");

/** @type HTMLInputElement */
const dataInput = document.getElementById("data");

/** @type HTMLCanvasElement */
const canvas = document.getElementById("result");
const ctx = canvas.getContext("2d");

/** @type HTMLImageElement */
const preview = document.getElementById("preview");

let jcrop = null;

fileInput.addEventListener("change", () => {
    if (!fileInput.files.length) {
        return;
    }

    ctx.clearRect(0, 0, canvas.width, canvas.height);
    canvas.width = null;
    canvas.height = null;

    const reader = new FileReader();
    reader.readAsDataURL(fileInput.files[0]);
    reader.onload = () => {
        preview.src = reader.result;

        bindJcrop();
    };
});

bindJcrop();

function bindJcrop() {
    jcrop?.destroy();

    jcrop = Jcrop.attach(preview);
    jcrop.listen("crop.change", event => {
        canvas.setAttribute("width", event.pos.w);
        canvas.setAttribute("height", event.pos.h);

        ctx.clearRect(0, 0, event.pos.w, event.pos.h);
        ctx.drawImage(preview, event.pos.x, event.pos.y, event.pos.w, event.pos.h, 0, 0, event.pos.w, event.pos.h);

        dataInput.value = canvas.toDataURL("image/png");
    })
}