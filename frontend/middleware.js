function getCookie(name) {
  const cookies = document.cookie.split("; ");
  const cookie = cookies.find((row) => row.startsWith(`${name}=`));
  return cookie ? cookie.split("=")[1] : null;
}

const token = getCookie("token");

async function protectedEndpoint() {
  try {
    const response = await fetch(
      "http://localhost/backend/protected/protected_endpoint.php",
      {
        method: "POST",
        headers: {
          Authorization: `Bearer ${token}`,
          "Content-Type": "application/json",
        },
      }
    );

    const result = await response.json();

    if (result.status === "success") {
      alert("Protected endpoint accessed successfully!");
      document.cookie = `id=${result.data.id}; path=/; max-age=3600; secure; samesite=Strict`;
    } else {
      window.location.href = "index.html";
      alert(result.message || "Registration failed");
    }
  } catch (error) {
    console.error("Error:", error);
    alert("An error occurred. Please try again.");
  }
}
protectedEndpoint();
