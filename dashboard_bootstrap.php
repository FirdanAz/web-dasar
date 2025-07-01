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
      padding-top: 100px;
    }
  </style>
</head>

<body>
  <!-- Navbar -->
  <nav class="navbar navbar-dark bg-dark fixed-top shadow px-3">
    <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">Company name</a>
    <input class="form-control form-control-dark w-100 ms-3" type="text" placeholder="Search" aria-label="Search">
  </nav>

  <div class="container-fluid">
    <div class="row">
      <!-- Sidebar -->
      <nav class="col-md-2 d-none d-md-block bg-light sidebar">
        <div class="sidebar-sticky pt-3">
          <ul class="nav flex-column">
            <li class="nav-item">
              <a class="nav-link" href="#" onclick="toggleEditUser()">
                <span data-feather="settings"></span>
                Edit User
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-danger" href="#" onclick="logout()">
                <span data-feather="log-out"></span>
                Logout
              </a>
            </li>
          </ul>
        </div>
      </nav>

      <!-- Main Content -->
      <main id="dashboardContent" role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">Dashboard</h1>
        </div>

        <canvas class="my-4 w-100" id="myChart" width="900" height="380"></canvas>

      </main>
      <div id="editUserSection" class="col-md-9 ml-sm-auto col-lg-10 px-4" style="display: none; margin-top: 20px;">
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
        <div id="saveAlert" class="alert alert-success mt-2" style="display: none;">User berhasil diubah!</div>
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
      window.location.href = "index.html";
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