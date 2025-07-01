<?php
session_start();
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard - Artha Cerdas</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      padding-top: 70px;
      background-color: #f8f9fa;
    }

    .sidebar {
      height: 100vh;
      padding-top: 1rem;
      background-color: #ffffff;
      border-right: 1px solid #dee2e6;
      box-shadow: 2px 0 5px rgba(0, 0, 0, 0.05);
    }

    .nav-link {
      font-weight: 500;
      color: #333;
    }

    .nav-link.active,
    .nav-link:hover {
      color: #0d6efd;
    }

    main {
      background-color: #ffffff;
      border-radius: 8px;
      padding: 2rem;
      margin-top: 1rem;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
    }

    #editUserSection {
      background-color: #ffffff;
      border-radius: 8px;
      padding: 2rem;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
    }

    .navbar-brand {
      font-size: 1.25rem;
    }
  </style>
</head>

<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top shadow-sm px-3">
    <a class="navbar-brand fw-semibold me-4 d-flex align-items-center" href="#">
      <img src="logo.png" alt="Logo" width="30" height="30" class="me-2">
      <span>Artha Cerdas</span>
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain"
      aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarMain">
      <form class="d-flex ms-auto me-3 w-50">
        <input class="form-control form-control-dark" type="search" placeholder="Cari data..." aria-label="Search">
      </form>

      <ul class="navbar-nav mb-2 mb-lg-0">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button"
            data-bs-toggle="dropdown" aria-expanded="false">
            <img src="logo.png" alt="Avatar" width="32" height="32" class="rounded-circle me-2">
            <span>Admin</span>
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
            <li><a class="dropdown-item" href="#" onclick="toggleEditUser()">Edit User</a></li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li><a class="dropdown-item text-danger" href="#" onclick="logout()">Logout</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </nav>

  <div class="container-fluid">
    <div class="row">
      <!-- Sidebar -->
      <nav class="col-md-2 d-none d-md-block sidebar position-fixed">
        <div class="pt-3">
          <ul class="nav flex-column">
            <li class="nav-item">
              <a class="nav-link active" href="#" onclick="kembaliKeDashboard()">
                <i data-feather="home" class="me-2"></i> Dashboard
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#" onclick="toggleEditUser()">
                <i data-feather="user" class="me-2"></i> Edit User
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-danger" href="#" onclick="logout()">
                <i data-feather="log-out" class="me-2"></i> Logout
              </a>
            </li>
          </ul>
        </div>
      </nav>

      <!-- Main Content -->
      <main id="dashboardContent" class="ms-md-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">Dashboard</h1>
        </div>

        <canvas class="my-4 w-100" id="myChart" width="900" height="380"></canvas>

      </main>
      <div id="editUserSection" class="ms-md-auto col-lg-10 px-md-4" style="display: none;">
        <h4>Edit User</h4>
        <form id="editUserForm" style="max-width: 400px;">
          <div class="mb-3">
            <label for="editUsername" class="form-label">Username</label>
            <input type="text" class="form-control" id="editUsername" required>
          </div>
          <div class="mb-3">
            <label for="editPassword" class="form-label">Password</label>
            <input type="password" class="form-control" id="editPassword" required>
          </div>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
        <div id="saveAlert" class="alert alert-success mt-3 fade show" style="display: none;">
           User berhasil diubah!
        </div>

      </div>
    </div>
  </div>

  <!-- JS Dependencies -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@2.7.1/dist/Chart.min.js"></script>

  <!-- Feather Icons -->
  <script>
    feather.replace();
  </script>

  <!-- Chart.js -->
  <script>
    var ctx = document.getElementById("myChart");
    var myChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
        datasets: [{
          data: [15339, 21345, 18483, 24003, 23489, 24092, 12034],
          lineTension: 0,
          backgroundColor: 'transparent',
          borderColor: '#007bff',
          borderWidth: 4,
          pointBackgroundColor: '#007bff'
        }]
      },
      options: {
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero: false
            }
          }]
        },
        legend: {
          display: false,
        }
      }
    });
  </script>

  <!-- Login & Edit User Logic -->
  <script>
    // Redirect ke login jika belum login
    if (sessionStorage.getItem("loggedIn") !== "true") {
      window.location.href = "index.html";
    }

    function logout() {
      sessionStorage.removeItem("loggedIn");
      window.location.href = "logout-bootstrap.php";
    }

    function toggleEditUser() {
      const dashboard = document.getElementById("dashboardContent");
      const editSection = document.getElementById("editUserSection");

      const userData = JSON.parse(localStorage.getItem("userData")) || {
        username: "usm",
        password: "123"
      };
      document.getElementById("editUsername").value = userData.username;
      document.getElementById("editPassword").value = userData.password;

      dashboard.style.display = "none";
      editSection.style.display = "block";
    }

    function kembaliKeDashboard() {
      document.getElementById("editUserSection").style.display = "none";
      document.getElementById("dashboardContent").style.display = "block";
    }

    document.getElementById("editUserForm").addEventListener("submit", function(e) {
      e.preventDefault();
      const newUser = {
        username: document.getElementById("editUsername").value.trim(),
        password: document.getElementById("editPassword").value.trim()
      };
      localStorage.setItem("userData", JSON.stringify(newUser));
      document.getElementById("saveAlert").style.display = "block";
      setTimeout(() => {
        document.getElementById("saveAlert").style.display = "none";
      }, 2000);
    });
  </script>
</body>

</html>