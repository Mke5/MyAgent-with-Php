<div class="loader-container">
    <div class="loader">

    </div>
</div>

<script>
    const loaderKontainer = document.querySelector('.loader-container');
    const pageContent = document.getElementById('page-content');


    window.addEventListener('load', ()=>{
        loaderKontainer.classList.add('hidden');
        pageContent.classList.add('visible');
    })
</script>