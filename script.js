document.getElementById('login-form').addEventListener('submit', function(event) {
    event.preventDefault(); 

    const role = document.getElementById('role').value;
    const userId = document.getElementById('user-id').value;
    const password = document.getElementById('password').value;

    const users = [
        { id: '1', password: 'password1', role: 'student' },
        { id: '2', password: 'password2', role: 'parent' },
        { id: '3', password: 'password3', role: 'teacher' },
    ];

    const user = users.find(u => u.id === userId && u.password === password && u.role === role);

    const message = document.getElementById('message');

    if (user) {
        message.textContent = `Mirë se erdhët, ${user.role}!`;
        switch (user.role) {
            case 'student':
                window.location.href = 'studenti.html'; 
                break;
            case 'parent':
                window.location.href = 'p.html'; 
                break;
            case 'teacher':
                window.location.href = 't.html'; 
                break;
        }
    }else if(role=='taram'){
        message.textContent= 'Zgjidhni statusin tuaj';
    }
     else  {
        message.textContent = 'ID ose fjalëkalimi i gabuar.';
    }
});



