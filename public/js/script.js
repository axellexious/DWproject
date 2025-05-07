/**
 * Custom JavaScript for AI-Exam System
 */

document.addEventListener("DOMContentLoaded", function () {
  // Auto-hide flash messages after 5 seconds
  const flashMessage = document.getElementById("msg-flash");
  if (flashMessage) {
    setTimeout(function () {
      flashMessage.style.transition = "opacity 1s ease-out";
      flashMessage.style.opacity = 0;
      setTimeout(function () {
        flashMessage.remove();
      }, 1000);
    }, 5000);
  }

  // File input custom styling
  const fileInputs = document.querySelectorAll('input[type="file"]');
  fileInputs.forEach(function (input) {
    input.addEventListener("change", function (e) {
      const fileName = e.target.files[0]?.name;
      const fileLabel = input.nextElementSibling;
      if (fileLabel && fileLabel.classList.contains("form-file-label")) {
        fileLabel.textContent = fileName || "Choose file";
      }
    });
  });

  // Course filter dynamic topic loading
  const courseSelect = document.getElementById("course_code");
  const topicSelect = document.getElementById("topic_id");

  if (courseSelect && topicSelect) {
    courseSelect.addEventListener("change", function () {
      const courseCode = this.value;
      if (courseCode) {
        // Fetch topics for the selected course via AJAX
        fetch(
          `${window.location.origin}/exam-system/topics/getByCourse/${courseCode}`
        )
          .then((response) => response.json())
          .then((data) => {
            // Clear previous options
            topicSelect.innerHTML =
              '<option value="" selected disabled>Select a topic</option>';

            // Add new options
            data.forEach((topic) => {
              const option = document.createElement("option");
              option.value = topic.topicID;
              option.textContent = topic.topicDesc;
              topicSelect.appendChild(option);
            });

            // Enable the topic select
            topicSelect.disabled = false;
          })
          .catch((error) => console.error("Error loading topics:", error));
      } else {
        // Disable and reset topic select if no course is selected
        topicSelect.innerHTML =
          '<option value="" selected disabled>Select a topic</option>';
        topicSelect.disabled = true;
      }
    });
  }

  // Tooltip initialization
  const tooltipTriggerList = [].slice.call(
    document.querySelectorAll('[data-bs-toggle="tooltip"]')
  );
  tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
  });

  // Table filter/search functionality
  const tableFilter = document.getElementById("tableSearch");
  if (tableFilter) {
    tableFilter.addEventListener("keyup", function () {
      const searchText = this.value.toLowerCase();
      const table = document.querySelector(".table");
      const rows = table.querySelectorAll("tbody tr");

      rows.forEach(function (row) {
        const text = row.textContent.toLowerCase();
        if (text.includes(searchText)) {
          row.style.display = "";
        } else {
          row.style.display = "none";
        }
      });
    });
  }

  // Add confirmation for delete actions
  const deleteButtons = document.querySelectorAll(".btn-delete");
  deleteButtons.forEach(function (button) {
    button.addEventListener("click", function (e) {
      if (
        !confirm(
          "Are you sure you want to delete this item? This action cannot be undone."
        )
      ) {
        e.preventDefault();
      }
    });
  });
});
