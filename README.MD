# Login Page with Tailwind CSS

This project is a responsive and modern login page designed using **Tailwind CSS**. It includes a functional login form that sends user credentials to a backend endpoint for authentication.

## Features

- **Responsive Design**: Fully responsive layout optimized for all screen sizes.
- **Modern UI**: Built with Tailwind CSS for sleek and accessible design.
- **Interactive Elements**: Input fields and buttons with hover and focus states.
- **Form Submission**: Sends user credentials to a backend endpoint via `fetch` API.
- **Secure Authentication**: Stores authentication tokens securely in cookies.

## Technologies Used

- **HTML**: Markup structure of the login page.
- **Tailwind CSS**: For fast and efficient styling.
- **JavaScript**: Handles form submission and communication with the backend.

## Prerequisites

Before running this project, ensure you have:

- A web server (e.g., XAMPP, WAMP, or any local server environment).
- Backend API to handle login requests (expected endpoint: `http://localhost/backend/public/index.php`).

## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/your-username/login-page.git
   ```

2. Navigate to the project directory:
   ```bash
   cd login-page
   ```

3. Open the `index.html` file in your preferred browser or host it on a web server.

## Usage

1. Enter a valid username and password in the respective fields.
2. Click the "Login" button.
3. If the credentials are correct, the user is redirected to `dashboard.html`.
4. If the credentials are incorrect, an error message is displayed.

## File Structure

```
login-page/
├── index.html       # Main login page
├── register.html    # Registration page link (optional)
├── README.md        # Project documentation
```

## Customization

- **Backend Endpoint**: Update the `fetch` URL in the JavaScript code to match your backend endpoint.
- **Styling**: Modify the Tailwind CSS classes in `index.html` for a customized look.

## Future Enhancements

- Add password recovery functionality.
- Include validation for stronger password requirements.
- Implement multi-language support.

## Contributing

Contributions are welcome! If you'd like to enhance this project, feel free to fork the repository and submit a pull request.

## License

This project is licensed under the [MIT License](LICENSE).

---

### Contact
For any questions or feedback, reach out to [your-email@example.com](mailto:your-email@example.com).

---

Happy coding!
