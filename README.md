# Send-Email API 🚀

A lightweight PHP API for sending emails using **multiple SMTP accounts**, with support for **HTML emails**, **attachments**, and **API key authentication**.  

---

## Features

- Multiple SMTP accounts configurable via `.env`  
- HTML emails + multiple attachments  
- API key authentication per project  
- Safe credentials
- Select sender account (`from`) per email  

---

## Quick Setup

1. Clone the repository:  

```bash
git clone https://github.com/username/send-email.git
cd send-email
```
2. Create .env in root (send-email/.env) with your SMTP credentials, Host and Port:

```ini
MAIL_HELLO_EMAIL="hello@domain.com"
MAIL_HELLO_PASS="yourpassword"

MAIL_TEST_EMAIL="test@domain.com"
MAIL_TEST_PASS="yourpassword"

MAIL_CONTACT_EMAIL="contact@domain.com"
MAIL_CONTACT_PASS="yourpassword"

MAIL_HOST="mail.domain.com"
MAIL_PORT=465
```
3. Configure API keys in config/security.php

4. Installing PHPMailer

- Download PHPMailer from [GitHub](https://github.com/PHPMailer/PHPMailer) → **Code → Download ZIP**.  
- Unzip and rename `PHPMailer-master` → `PHPMailer`.  
- Move the folder into your project root:

---
## API Usage

### HEADERS

```
X-API-KEY: your_api_key_here
Content-Type: multipart/form-data
```

### Body Parameters

| Name            | Type   | Description                           |
| --------------- | ------ | ------------------------------------- |
| `to`            | string | Recipient email                       |
| `subject`       | string | Email subject (default: "No subject") |
| `body`          | string | HTML content                          |
| `from`          | string | Sender account key (default: "hello") |
| `attachments[]` | file[] | Optional multiple files               |

### curl

```bash
curl -X POST "http://yourdomain.com/api/send-email.php" \
  -H "X-API-KEY: your_api_key_here" \
  -F "to=recipient@example.com" \
  -F "subject=Test Email" \
  -F "body=<h1>Hello!</h1><p>This is a test email.</p>" \
  -F "from=test" \
  -F "attachments[]=@/path/to/file1.pdf" \
  -F "attachments[]=@/path/to/file2.jpg"
```

### Example Response

#### Success
```json
{
  "status": "ok",
  "message": "Email sent successfully from test@domain.com"
}
```

#### Error
```json
{
  "status": "error",
  "message": "Invalid API key"
}
```