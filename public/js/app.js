(function() {

  const btnDelete = document.querySelectorAll('.btn-danger');
  const modal = document.querySelector('#modal');
  const modalBtns = modal.querySelectorAll('button');

  let urlDelete = '';

  btnDelete.forEach(function(btn) {
    btn.addEventListener('click', function(e) {
      e.preventDefault(); // bloque la requête http

      //deplacement du modal
      let topPosition = e.clientY;
      modal.style.top = topPosition + 'px';

      //Mémorisation de le l'url permettant la suppression
      urlDelete = e.target.href;

      // let t = modal.offsetTop + 100;
      let t = e.clientY;
      modal.style.top = t + 'px';

    })
  })

  modalBtns[0].addEventListener('click', function(e) {
    window.location.href = urlDelete;

  })

  modalBtns[1].addEventListener('click', function(e) {
    modal.style.top = '-100px';
  })

})()
