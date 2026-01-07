

## **IOPSF - Gold Investment Platform**

This is a Laravel-based web application for managing gold investments with role-based access control. Here's what I found:

### **Core Architecture**

**Framework & Dependencies:**
- Laravel 12.0 with PHP 8.2+
- Uses Laravel Breeze for authentication
- Google2FA for two-factor authentication
- Tailwind CSS for styling

### **User Roles & Authentication**

**Two Main Roles:**
1. **Client** - Regular users who can:
   - View their gold balance
   - Upload documents
   - Request withdrawals
   - Manage profile settings
   - Use two-factor authentication

2. **Admin** - Administrative users who can:
   - Manage all users
   - Process withdrawal requests
   - Approve/reject documents
   - View system statistics
   - Deposit gold to user accounts

### **Key Features**

**For Clients:**
- **Dashboard** with balance visibility toggle
- **Document Management** - upload, view, download documents
- **Withdrawal Requests** - submit and track withdrawal requests
- **Two-Factor Authentication** - optional 2FA using Google Authenticator
- **Profile Management** - update personal info, PIN codes
- **Transaction History** - view gold transactions

**For Admins:**
- **User Management** - create, edit, view all users
- **Deposit Management** - add gold to user accounts
- **Withdrawal Processing** - approve/reject withdrawal requests
- **Document Approval** - review and approve user documents
- **System Analytics** - view user statistics and activity

### **Database Structure**

**Core Models:**
- `User` - with gold balance, roles, 2FA settings
- `Transaction` - financial transactions
- `GoldTransaction` - gold-specific transactions with balance tracking
- `Document` - user uploaded documents with approval workflow
- `WithdrawalRequest` - withdrawal requests with status tracking
- `Role` - role-based access control
- `Activity` - system activity logging

### **Security Features**

1. **Restricted Registration** - Public registration is disabled; accounts are admin-created only.
2. **Role-based Middleware** - `AdminMiddleware` and `ClientMiddleware`
3. **Two-Factor Authentication** - optional 2FA for enhanced security
4. **PIN Code Protection** - additional security layer
5. **Document Security** - secure file uploads and downloads
6. **Transaction Logging** - audit trail for all financial activities

### **Key Controllers**

- `Client/DashboardController` - client dashboard functionality
- `Admin/DashboardController` - admin dashboard with statistics
- `WithdrawalRequestController` - handles withdrawal workflow
- `DocumentController` - document management
- `AdminUserController` - user management for admins

### **Frontend**

- **Modern UI** using Tailwind CSS
- **Responsive Design** for mobile and desktop
- **Component-based** Blade templates
- **Real-time Updates** for balance and status changes

### **Business Logic**

**Gold Investment Focus:**
- Users maintain gold balances (in ounces)
- All transactions are tracked with before/after balances
- Withdrawal requests require admin approval
- Document verification workflow for compliance

**Workflow:**
1. Admins create user accounts via the Admin Panel.
2. Users receive an invitation email to access the platform.
3. Users can request withdrawals (pending admin approval)
4. Document uploads require admin verification
5. All activities are logged for audit purposes

This appears to be a comprehensive gold investment platform with robust security features, role-based access control, and a complete workflow for managing gold investments and withdrawals.