<?php require_once path('/app/Views/Shares/head.php') ?>

<?php require_once path('/app/Views/Shares/open_body.php') ?>


<nav class="navbar">
    <div class="container">
        <a class="navbar-brand" href="/">Shopping List</a>
        <ul class="navbar-nav">
            <li class="nav-item"><a class="nav-link" href="/login">Login</a></li>
            <li class="nav-item"><a class="nav-link active" href="/register">Register</a></li>
            <li class="nav-item">
                <a href="" class="nav-item">logout
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

        <form id="shopping-items" method="POST" action="/api/shopping-items">
            <div class="form-group">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="note" class="form-label">Email address</label>
                <textarea class="form-control" id="note" name="note"></textarea>
            </div>
            <button type="submit" class="btn btn-primary w-100">Add to list</button>
        </form>

    </div>

    <div class="card">

        <div class="shopping-list">
            <div class="list-item-wrapper">
                <div class="list-item">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <path fill="currentColor" d="M21 7L9 19l-5.5-5.5l1.41-1.41L9 16.17L19.59 5.59z"/>
                        </svg>
                    </div>
                    <div class="list-title">Name</div>
                    <div class="list-note">Note</div>
                </div>
                <div class="list-actions">
                    <button>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <path fill="currentColor"
                                  d="M19 4h-3.5l-1-1h-5l-1 1H5v2h14M6 19a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V7H6z"/>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="list-item-wrapper">
                <div class="list-item checked">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <path fill="currentColor" d="M21 7L9 19l-5.5-5.5l1.41-1.41L9 16.17L19.59 5.59z"/>
                        </svg>
                    </div>
                    <div class="list-title">Name</div>
                    <div class="list-note">Note</div>
                </div>
                <div class="list-actions">
                    <button>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <path fill="currentColor"
                                  d="M19 4h-3.5l-1-1h-5l-1 1H5v2h14M6 19a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V7H6z"/>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="list-item-wrapper">
                <div class="list-item">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <path fill="currentColor" d="M21 7L9 19l-5.5-5.5l1.41-1.41L9 16.17L19.59 5.59z"/>
                        </svg>
                    </div>
                    <div class="list-title">Name</div>
                    <div class="list-note">Note</div>
                </div>

                <div class="list-actions">
                    <button>
                        edit
                    </button>
                    <button>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <path fill="currentColor"
                                  d="M19 4h-3.5l-1-1h-5l-1 1H5v2h14M6 19a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V7H6z"/>
                        </svg>
                    </button>
                </div>

                <form style="" class="edit-form" method="POST" action="/api/shopping-items">
                    <div class="form-group">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="note" class="form-label">Email address</label>
                        <textarea class="form-control" id="note" name="note"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Add to list</button>
                </form>
            </div>
        </div>

    </div>


<?php require_once path('/app/Views/Shares/close_body.php') ?>
