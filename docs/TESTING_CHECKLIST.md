# Bali Realty Holidays - Testing Checklist

## 📋 Overview

This document provides comprehensive testing procedures for both the **User Frontend** and **Admin Panel** of the Bali Realty Holidays Villa website.

---

## 🏠 Part 1: User Frontend Testing

### 1. Homepage Testing

| # | Test Case | Steps | Expected Result | Status |
|---|-----------|-------|-----------------|--------|
| 1.1 | Homepage loads correctly | Navigate to http://localhost:8000/ | Page loads with hero image, navigation, and content | ⬜ |
| 1.2 | Navigation menu works | Click each menu item (Home, Destinations, About, Contact) | Each page loads correctly | ⬜ |
| 1.3 | Hero search bar functions | Select area, bedrooms, date and click search | Redirects to destinations page with filters applied | ⬜ |
| 1.4 | Featured villas display | Scroll to Featured Villas section | 6 featured villas shown with images and prices | ⬜ |
| 1.5 | Villa card links work | Click on any featured villa card | Navigates to villa detail page | ⬜ |
| 1.6 | Destinations section works | Click on any destination in Popular Destinations | Navigates to that area's page | ⬜ |
| 1.7 | Testimonials display | Scroll to Guest Stories section | 4 testimonials shown | ⬜ |
| 1.8 | CTA buttons work | Click "Browse Villas" and "Contact Us" buttons | Navigate to correct pages | ⬜ |
| 1.9 | Footer links work | Click all footer links | All links navigate correctly | ⬜ |
| 1.10 | Mobile menu toggle | Resize browser to mobile size, click menu button | Mobile menu opens/closes | ⬜ |

### 2. Destinations/Villa Listing Testing

| # | Test Case | Steps | Expected Result | Status |
|---|-----------|-------|-----------------|--------|
| 2.1 | Destinations page loads | Navigate to /destinations | Page shows all 10 villas | ⬜ |
| 2.2 | Area filter works | Select "Canggu" from area dropdown | Only Canggu villas shown (2 villas) | ⬜ |
| 2.3 | Bedroom filter works | Select "3+ Bedrooms" | Only villas with 3+ bedrooms shown | ⬜ |
| 2.4 | Flexible bedroom config filter | Select "3" bedrooms | Villa Victoriya appears (has 3BR config) | ⬜ |
| 2.5 | Sort by price low-high | Select "Price: Low to High" | Villas sorted by starting price ascending | ⬜ |
| 2.6 | Sort by price high-low | Select "Price: High to Low" | Villas sorted by starting price descending | ⬜ |
| 2.7 | Sort by bedrooms | Select "Most Bedrooms" | 6BR villa appears first | ⬜ |
| 2.8 | Clear filters | Click "Clear Filters" | All filters reset, all villas shown | ⬜ |
| 2.9 | Pagination works | If more than 12 villas, click page numbers | Next/previous pages load correctly | ⬜ |
| 2.10 | Villa count displays | Check top of listing | Shows correct count (e.g., "10 villas found") | ⬜ |

### 3. Area Detail Page Testing

| # | Test Case | Steps | Expected Result | Status |
|---|-----------|-------|-----------------|--------|
| 3.1 | Area page loads | Navigate to /destinations/canggu | Shows only Canggu villas | ⬜ |
| 3.2 | Area description displays | Check page header | Area description shown | ⬜ |
| 3.3 | Villa count correct | Check listing | Shows correct villa count for area | ⬜ |
| 3.4 | Back to all villas | Click "All Villas" or navigate to /destinations | Shows all villas | ⬜ |

### 4. Villa Detail Page Testing

| # | Test Case | Steps | Expected Result | Status |
|---|-----------|-------|-----------------|--------|
| 4.1 | Villa page loads | Click any villa from listing | Villa detail page loads with hero image | ⬜ |
| 4.2 | Villa info bar displays | Check top of page | Name, area, bedrooms, bathrooms, guests shown | ⬜ |
| 4.3 | Bedroom range displays | Check Villa Royale (flexible config) | Shows "3-5 Bedrooms" | ⬜ |
| 4.4 | Flexible config badge | Check Villa Royale | Shows "Also available as: 3, 4, 5 bedroom configurations" | ⬜ |
| 4.5 | Price displays | Check price section | Shows starting price from lowest config | ⬜ |
| 4.6 | Overview tab works | Click "Overview" tab | Shows villa description and gallery | ⬜ |
| 4.7 | Facilities tab works | Click "Facilities" tab | Shows all facility amenities with icons | ⬜ |
| 4.8 | Services tab works | Click "Services" tab | Shows all service amenities | ⬜ |
| 4.9 | Rates tab - bedroom configs | Click "Rates" tab on Villa Royale | Shows 3 bedroom configurations with prices | ⬜ |
| 4.10 | Rates tab - seasonal rates | Check Rates tab | Shows 4 seasonal rates (Low, Shoulder, High, Peak) | ⬜ |
| 4.11 | Inclusions display | Check Rates tab | Shows complimentary items | ⬜ |
| 4.12 | Location tab works | Click "Location" tab | Shows map placeholder and area info | ⬜ |
| 4.13 | Reviews display | If villa has reviews | Shows guest reviews with ratings | ⬜ |
| 4.14 | Inquiry form displays | Check sidebar | Shows complete inquiry form | ⬜ |
| 4.15 | Related villas display | Scroll to bottom | Shows 4 related villas from same area | ⬜ |

### 5. Inquiry Form Testing

| # | Test Case | Steps | Expected Result | Status |
|---|-----------|-------|-----------------|--------|
| 5.1 | Form validation - empty | Submit form without filling fields | Shows validation errors for required fields | ⬜ |
| 5.2 | Form validation - email | Enter invalid email | Shows email validation error | ⬜ |
| 5.3 | Form validation - dates | Enter check-out before check-in | Shows date validation error | ⬜ |
| 5.4 | Successful submission | Fill all fields correctly and submit | Shows success message | ⬜ |
| 5.5 | Success message displays | After submission | "Thank you for your inquiry..." message shown | ⬜ |
| 5.6 | Form resets after submit | After successful submission | Form fields are cleared | ⬜ |
| 5.7 | Email notification sent | Check admin email | Admin receives inquiry notification email | ⬜ |

### 6. Contact Page Testing

| # | Test Case | Steps | Expected Result | Status |
|---|-----------|-------|-----------------|--------|
| 6.1 | Contact page loads | Navigate to /contact | Page loads with form and contact info | ⬜ |
| 6.2 | Contact info displays | Check right sidebar | Email, phone, address, hours shown | ⬜ |
| 6.3 | Form validation | Submit empty form | Shows validation errors | ⬜ |
| 6.4 | Successful submission | Fill form correctly and submit | Shows success message | ⬜ |
| 6.5 | Inquiry created in admin | Check admin panel | Contact form appears as inquiry | ⬜ |

### 7. About Page Testing

| # | Test Case | Steps | Expected Result | Status |
|---|-----------|-------|-----------------|--------|
| 7.1 | About page loads | Navigate to /about | Page loads with company story | ⬜ |
| 7.2 | Content displays | Check all sections | Story, values, stats, CTA all visible | ⬜ |
| 7.3 | CTA buttons work | Click "Browse Villas" and "Contact Us" | Navigate to correct pages | ⬜ |

### 8. Mobile Responsiveness Testing

| # | Test Case | Steps | Expected Result | Status |
|---|-----------|-------|-----------------|--------|
| 8.1 | Mobile menu | Resize to <768px, click menu button | Menu opens/closes smoothly | ⬜ |
| 8.2 | Villa grid responsive | View listings on mobile | Villas display in 1 column | ⬜ |
| 8.3 | Images scale correctly | Check all images on mobile | Images fit screen without overflow | ⬜ |
| 8.4 | Forms usable on mobile | Try filling inquiry form on mobile | All fields accessible and usable | ⬜ |
| 8.5 | Tabs work on mobile | Click tabs on villa detail page | Tabs switch correctly | ⬜ |
| 8.6 | Footer responsive | Check footer on mobile | Footer stacks correctly | ⬜ |

### 9. Image Lazy Loading Testing

| # | Test Case | Steps | Expected Result | Status |
|---|-----------|-------|-----------------|--------|
| 9.1 | Hero image loads immediately | Check page load | Hero image loads immediately (loading="eager") | ⬜ |
| 9.2 | Villa images lazy load | Scroll down page | Images load as they come into viewport | ⬜ |
| 9.3 | Network tab check | Open DevTools Network tab, reload | Images load progressively on scroll | ⬜ |

---

## 🔐 Part 2: Admin Panel Testing

### 10. Admin Authentication Testing

| # | Test Case | Steps | Expected Result | Status |
|---|-----------|-------|-----------------|--------|
| 10.1 | Login page loads | Navigate to /admin/login | Login form displays | ⬜ |
| 10.2 | Login with valid credentials | Email: admin@balirealtyhv.com, Password: admin123 | Redirects to dashboard | ⬜ |
| 10.3 | Login with invalid credentials | Enter wrong email/password | Shows error message | ⬜ |
| 10.4 | Remember me function | Check "Remember me", login, close browser, return | Still logged in | ⬜ |
| 10.5 | Logout works | Click logout icon | Redirects to login page, session cleared | ⬜ |
| 10.6 | Protected routes | Try accessing /admin/dashboard while logged out | Redirects to login | ⬜ |

### 11. Admin Dashboard Testing

| # | Test Case | Steps | Expected Result | Status |
|---|-----------|-------|-----------------|--------|
| 11.1 | Dashboard loads | After login | Dashboard displays with stats | ⬜ |
| 11.2 | Stats display correctly | Check stat cards | Total villas (10), published, new inquiries shown | ⬜ |
| 11.3 | Recent inquiries shows | Check recent inquiries section | Shows latest inquiries | ⬜ |
| 11.4 | Quick actions work | Click "Add New Villa", "View Inquiries", "Add Review" | Navigate to correct pages | ⬜ |
| 11.5 | Draft villas section | Check draft villas | Shows villas with draft status | ⬜ |

### 12. Villa Management Testing

| # | Test Case | Steps | Expected Result | Status |
|---|-----------|-------|-----------------|--------|
| 12.1 | Villa list page loads | Click "Villas" in sidebar | Shows all 10 villas in table | ⬜ |
| 12.2 | Villa search/filter | Use pagination if available | Can navigate through villas | ⬜ |
| 12.3 | View villa | Click eye icon | Opens villa detail view | ⬜ |
| 12.4 | Edit villa | Click edit icon | Opens edit form with pre-filled data | ⬜ |
| 12.5 | Create new villa | Click "Add New Villa" | Opens create form | ⬜ |
| 12.6 | Delete villa | Click delete icon, confirm | Villa deleted, list updates | ⬜ |

### 13. Villa Create/Edit Testing

| # | Test Case | Steps | Expected Result | Status |
|---|-----------|-------|-----------------|--------|
| 13.1 | Basic info form | Fill name, area, description | Saves correctly | ⬜ |
| 13.2 | Property details | Fill bedrooms, bathrooms, guests, size | Saves correctly | ⬜ |
| 13.3 | Amenities selection | Check multiple amenities | Saves and displays on view | ⬜ |
| 13.4 | Seasonal rates | Fill rates for all 4 seasons | Saves correctly | ⬜ |
| 13.5 | Flexible config checkbox | Check "flexible bedroom configurations" | Shows bedroom config section | ⬜ |
| 13.6 | Add bedroom config | Click "Add Bedroom Configuration" | New config row appears | ⬜ |
| 13.7 | Multiple bedroom configs | Add 3 configs (3BR, 4BR, 5BR) | All save correctly | ⬜ |
| 13.8 | Remove bedroom config | Click delete on config row | Row removed | ⬜ |
| 13.9 | Photo upload | Select images, choose category, upload | Photos saved and displayed | ⬜ |
| 13.10 | Delete photo | Click delete on existing photo | Photo deleted | ⬜ |
| 13.11 | Status toggle | Change status Draft/Published | Saves correctly | ⬜ |
| 13.12 | Featured toggle | Check/uncheck Featured | Saves correctly | ⬜ |
| 13.13 | iCal URL | Enter iCal URL, save | URL saved, sync button appears | ⬜ |

### 14. Amenity Management Testing

| # | Test Case | Steps | Expected Result | Status |
|---|-----------|-------|-----------------|--------|
| 14.1 | Amenity list loads | Click "Amenities" in sidebar | Shows all amenities grouped by category | ⬜ |
| 14.2 | Category summary | Check top cards | Shows count for Facilities, Services, Inclusions | ⬜ |
| 14.3 | Create amenity | Click "Add Amenity", fill form | Amenity created | ⬜ |
| 14.4 | Edit amenity | Click edit on existing amenity | Opens edit form with data | ⬜ |
| 14.5 | Delete amenity | Click delete, confirm | Amenity deleted | ⬜ |
| 14.6 | Active toggle | Uncheck "Active" on amenity | Amenity hidden from villa forms | ⬜ |

### 15. Inquiry Management Testing

| # | Test Case | Steps | Expected Result | Status |
|---|-----------|-------|-----------------|--------|
| 15.1 | Inquiry list loads | Click "Inquiries" in sidebar | Shows all inquiries | ⬜ |
| 15.2 | Stats display | Check top cards | Shows New, Contacted, Confirmed, Archived counts | ⬜ |
| 15.3 | View inquiry detail | Click "View" on inquiry | Opens full inquiry detail page | ⬜ |
| 15.4 | Update status | Change status dropdown | Status updates, color changes | ⬜ |
| 15.5 | Assign to staff | Select staff member, click assign | Inquiry assigned, staff shown | ⬜ |
| 15.6 | Add admin notes | Type notes, save | Notes saved and displayed | ⬜ |
| 15.7 | Delete inquiry | Click delete, confirm | Inquiry deleted | ⬜ |
| 15.8 | Timeline displays | Check inquiry detail | Shows created, contacted, confirmed timestamps | ⬜ |

### 16. Review Management Testing

| # | Test Case | Steps | Expected Result | Status |
|---|-----------|-------|-----------------|--------|
| 16.1 | Review list loads | Click "Reviews" in sidebar | Shows all reviews | ⬜ |
| 16.2 | Create review | Click "Add Review", fill form | Review created | ⬜ |
| 16.3 | Edit review | Click edit on existing review | Opens edit form with data | ⬜ |
| 16.4 | Toggle publish | Click publish toggle | Review published/unpublished | ⬜ |
| 16.5 | Add response | Fill response text, submit | Response saved | ⬜ |
| 16.6 | Delete review | Click delete, confirm | Review deleted | ⬜ |
| 16.7 | Featured toggle | Check featured | Review marked as featured | ⬜ |

### 17. iCal Sync Testing

| # | Test Case | Steps | Expected Result | Status |
|---|-----------|-------|-----------------|--------|
| 17.1 | iCal export | On villa edit, click "Download iCal" | Downloads .ics file | ⬜ |
| 17.2 | iCal import | Enter external iCal URL, submit | Imports events from URL | ⬜ |
| 17.3 | Manual sync | Click "Sync Now" button | Syncs with external calendar | ⬜ |
| 17.4 | Auto-sync scheduled | Check Laravel scheduler | Runs hourly (configured in Kernel.php) | ⬜ |
| 17.5 | Run manual sync command | Run `php artisan ical:sync-all` | Syncs all villas with iCal URLs | ⬜ |

### 18. Admin Navigation & UI Testing

| # | Test Case | Steps | Expected Result | Status |
|---|-----------|-------|-----------------|--------|
| 18.1 | Sidebar navigation | Click each menu item | Navigates to correct section | ⬜ |
| 18.2 | Active state highlights | Navigate to each section | Current section highlighted in sidebar | ⬜ |
| 18.3 | Notification badge | Create new inquiry | Badge shows count on Inquiries menu | ⬜ |
| 18.4 | User profile displays | Check bottom of sidebar | Shows logged-in user name and role | ⬜ |
| 18.5 | Success messages | After any create/update | Green success message displays | ⬜ |
| 18.6 | Error messages | Trigger an error | Red error message displays | ⬜ |

---

## 🎯 Test Completion Summary

### Frontend Testing
- [ ] Homepage (10 tests)
- [ ] Destinations (10 tests)
- [ ] Area Detail (4 tests)
- [ ] Villa Detail (15 tests)
- [ ] Inquiry Form (7 tests)
- [ ] Contact Page (5 tests)
- [ ] About Page (3 tests)
- [ ] Mobile Responsiveness (6 tests)
- [ ] Image Lazy Loading (3 tests)

**Frontend Total: 63 tests**

### Admin Panel Testing
- [ ] Authentication (6 tests)
- [ ] Dashboard (5 tests)
- [ ] Villa Management (5 tests)
- [ ] Villa Create/Edit (13 tests)
- [ ] Amenity Management (6 tests)
- [ ] Inquiry Management (8 tests)
- [ ] Review Management (7 tests)
- [ ] iCal Sync (5 tests)
- [ ] Admin UI (6 tests)

**Admin Total: 61 tests**

---

## 📊 Overall Test Coverage

| Section | Tests | Pass | Fail | Skip | Coverage |
|---------|-------|------|------|------|----------|
| Frontend | 63 | ⬜ | ⬜ | ⬜ | 0% |
| Admin | 61 | ⬜ | ⬜ | ⬜ | 0% |
| **TOTAL** | **124** | **⬜** | **⬜** | **⬜** | **0%** |

---

## 🐛 Issues Log

| # | Section | Issue Description | Severity | Status |
|---|---------|-------------------|----------|--------|
| - | - | - | - | - |

---

## ✅ Sign-off

| Role | Name | Date | Signature |
|------|------|------|-----------|
| Tester | | | |
| Developer | | | |
| Project Manager | | | |

---

**Document Version:** 1.0  
**Last Updated:** March 8, 2026  
**Project:** Bali Realty Holidays Villa Portal
