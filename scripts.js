function toggleNav() {
    const sidebar = document.getElementById("mySidebar");
    const main = document.getElementById("main");
    const sidebarNav = document.getElementById('sidebarNav');

    if (sidebarNav.style.display === "none") {
        sidebar.style.width = "0px";
        main.style.marginLeft = "250px";
        sidebarNav.style.display = "block";
        document.body.style.overflow = "hidden";
    } else {
        sidebarNav.style.display = "none";
        sidebar.style.width = "0";
        main.style.marginLeft = "0";
        document.body.style.overflow = "auto";
    }
}

const sidebarNav = document.getElementById('sidebarNav');
const links = [
    { href: 'person1.html', text: 'Person 1' },
    { href: 'person2.html', text: 'Person 2' },
    { href: 'person3.html', text: 'Person 3' },
    { href: 'person4.html', text: 'Person 4' },
    { href: 'person5.html', text: 'Person 5' }
];

links.forEach(link => {
    const li = document.createElement('li');
    const a = document.createElement('a');
    a.href = link.href;
    a.textContent = link.text;
    li.appendChild(a);
    sidebarNav.appendChild(li);
});