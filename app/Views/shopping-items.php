<?php require_once path('/app/Views/Shares/head.php') ?>

<?php require_once path('/app/Views/Shares/open_body.php') ?>


<nav class="navbar">
    <div class="container">
        <a class="navbar-brand" href="/">Shopping List</a>
        <ul class="navbar-nav">
<!--            <li class="nav-item"><a class="nav-link" href="/login">Login</a></li>-->
<!--            <li class="nav-item"><a class="nav-link active" href="/register">Register</a></li>-->
            <li class="nav-item">

                <a href="" class="nav-item" id="logout">logout
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                           stroke-width="2">
                            <path d="M12 4h-7c-0.55 0 -1 0.45 -1 1v14c0 0.55 0.45 1 1 1h7"/>
                            <path d="M9 12h11.5"/>
                            <path d="M20.5 12l-3.5 -3.5M20.5 12l-3.5 3.5"/>
                        </g>
                    </svg>
                </a></li>
        </ul>
    </div>
</nav>


<div id="shopping-items" class="container">

    <div class="card" style="margin-bottom: 20px">


        <form id="add-item-form" method="POST" action="/api/shopping-items">
            <div class="form-group">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="note" class="form-label">Note</label>
                <textarea class="form-control" id="note" name="note"></textarea>
            </div>
            <input type="hidden" name="quantity" value="1">
            <button type="submit" class="btn btn-primary w-100">Add to your list</button>
        </form>

    </div>


    <div id="shopping-item-wrapper">
        <div class="card">

            <div class="shopping-list">

                <div class="list-item-wrapper">
                    <div class="list-item checked" onclick="this.classList.toggle('checked')">
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M21 7L9 19l-5.5-5.5l1.41-1.41L9 16.17L19.59 5.59z"/>
                            </svg>
                        </div>
                        <div class="list-title">Name</div>
                        <div class="list-note">Note</div>
                    </div>

                    <div class="list-actions">
                        <button class="edit-button"
                                onclick="this.parentElement.parentElement.querySelector('.edit-form').classList.toggle('open')">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                      d="M5 21q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h8.925l-2 2H5v14h14v-6.95l2-2V19q0 .825-.587 1.413T19 21zm4-6v-4.25l9.175-9.175q.3-.3.675-.45t.75-.15q.4 0 .763.15t.662.45L22.425 3q.275.3.425.663T23 4.4t-.137.738t-.438.662L13.25 15zM21.025 4.4l-1.4-1.4zM11 13h1.4l5.8-5.8l-.7-.7l-.725-.7L11 11.575zm6.5-6.5l-.725-.7zl.7.7z"/>
                            </svg>
                        </button>
                        <button class="remove-button">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                      d="M7 21q-.825 0-1.412-.587T5 19V6q-.425 0-.712-.288T4 5t.288-.712T5 4h4q0-.425.288-.712T10 3h4q.425 0 .713.288T15 4h4q.425 0 .713.288T20 5t-.288.713T19 6v13q0 .825-.587 1.413T17 21zM17 6H7v13h10zm-7 11q.425 0 .713-.288T11 16V9q0-.425-.288-.712T10 8t-.712.288T9 9v7q0 .425.288.713T10 17m4 0q.425 0 .713-.288T15 16V9q0-.425-.288-.712T14 8t-.712.288T13 9v7q0 .425.288.713T14 17M7 6v13z"/>
                            </svg>
                        </button>
                    </div>

                    <form style="" class="edit-form open" method="POST" action="/api/shopping-items">
                        <div class="form-group">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="note" class="form-label">Email address</label>
                            <textarea class="form-control" id="note" name="note"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Edit the list</button>
                    </form>
                </div>
            </div>

        </div>
    </div>


    <?php require_once path('/app/Views/Shares/close_body.php') ?>
