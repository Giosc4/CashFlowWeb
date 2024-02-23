<?php

function printNav()
{
    echo "        <nav class='navbar navbar-expand-lg navbar-light bg-light'>
    <a class='navbar-brand' href='../client/'><img src='../INFO/CashFlowApp LOGO.png' alt='LOGO' width='100px'></a>
    <div class='collapse navbar-collapse' id='navbarNav'>
        <ul class='navbar-nav ' id='navWords'>
            <li class='nav-item'>
                <a class='nav-link active navWord' aria-current='page' href='create_account_c.php'>Account</a>
            </li>
            <li class='nav-item '>
                <a class='nav-link active navWord' href='create_transaction_c.php'>Transazioni</a>
            </li>
            <li class='nav-item'>
                <a class='nav-link active navWord' href='statistics.php'>Dati Statistici</a>
            </li>
        </ul>
    </div>
</nav>";
}

function printFoot()
{
    echo "<footer class='footer mt-auto py-3 bg-light'>
    <div class='container'>
        <p class='text-center'>CashFlow Web by Giovanni Maria Savoca</p>
    </div>";
}
