function toggleNav() {
    const sidebar = document.getElementById("mySidebar");
    const main = document.getElementById("main");
    const sidebarNav = document.getElementById('sidebarNav');

    if (sidebarNav.style.display === "none") {
        sidebar.style.width = "7%";
        sidebar.style.padding = "7%";
        main.style.marginLeft = "0";
        sidebarNav.style.display = "block";
        document.body.style.overflow = "hidden";
    } else {
        sidebarNav.style.display = "none";
        sidebar.style.width = "0";
        sidebar.style.padding = "0";
        sidebarNav.style.width = "0";
        main.style.marginLeft = "0";
        document.body.style.overflow = "auto";
    }
}

const sidebarNav = document.getElementById('sidebarNav');
const links = [
    { href: 'person1.html', text: 'Angel' },
    { href: 'person2.html', text: 'Raul' },
    { href: 'person3.html', text: 'Dorzhi' },
    { href: 'person4.html', text: 'Sergio' },
    { href: 'person5.html', text: 'Andres' }
];

links.forEach(link => {
    const li = document.createElement('li');
    const a = document.createElement('a');
    a.href = link.href;
    a.textContent = link.text;
    li.appendChild(a);
    sidebarNav.appendChild(li);
});