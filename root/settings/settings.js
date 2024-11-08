function confirmation() {

    bulmaToast.toast({
       message: '<h1>Are you sure you want to go? 🥺</h1>',
       type: 'is-warning',
       duration: 100,
       dismissible: true,
       pauseOnHover: false,
       animate: { in: 'fade', out: 'fade' },
     })}

// see if user has clicked on the button twice
function doubleClick() {
    let button = document.getElementById("delete-account");
    if (button) {
        button.addEventListener("click", confirmation);
        button.addEventListener("click", function() {
            button.removeEventListener("click", confirmation);
            button.removeEventListener("click", doubleClick);
        }
        );
        return true;
    }
    return false;
}