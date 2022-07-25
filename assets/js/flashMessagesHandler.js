const fleshMessagesContainer = document.querySelector('#flesh-messages-container');

fleshMessagesContainer.addEventListener('click', ev => {
    ev.target.closest('.flesh-message').classList.add('d-none');
});

setTimeout(()=>{
    fleshMessagesContainer.classList.add('d-none');
},4000);
