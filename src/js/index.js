document.querySelectorAll('li a').forEach(e => {

    if (location.href.includes(e.href)) {
        e.classList.add('active')
    }
})