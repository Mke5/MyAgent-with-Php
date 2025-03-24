const display = document.querySelector('.listing-grid');


setInterval(() => {
    let xhr = new XMLHttpRequest();
    xhr.open("GET", "listings.php", true);
    xhr.onload = () => {
        if(xhr.readyState === XMLHttpRequest.DONE){
            console.log('yes');
            if(xhr.status === 200){
                location.href = "listing.php";
                let data = xhr.response;
                console.log(data);
                display.innerHTML = data;
            }
        }
    }
    xhr.send();
}, 500);