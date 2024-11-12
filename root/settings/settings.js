// This isnt being used at the moment

function confirmation() {

    bulmaToast.toast({
       message: '<h1>Are you sure you want to go? 🥺</h1>',
       type: 'is-warning',
       duration: 100,
       dismissible: true,
       pauseOnHover: false,
       animate: { in: 'fade', out: 'fade' },
     })}


     document.getElementById("delete-account").addEventListener("click", function() {

        // Show a confirmation toast with Bulma Toast
        bulmaToast.toast({
            message: '<h1>Are you sure you want to go? 🥺</h1>',
            type: 'is-warning',
            duration: 5000,
            dismissible: false,
            pauseOnHover: false,
            // onClick: function() {
            //     // Submit the form if the user confirms
            //     document.getElementById("delete-account-form").submit();
            // }
            onClose: function() {
                // Show a goodbye toast
                console.log("Goodbye! 😢");
                document.getElementById("delete-account").submit();
            }
        });
    });