# 📱 Responsive Design Testing Guide

## Cara Testing Responsive

### 1. Browser DevTools (F12)

#### Chrome/Edge DevTools:
1. Buka http://localhost:8000/
2. Tekan **F12** atau **Ctrl+Shift+I** (Cmd+Option+I di Mac)
3. Klik icon **Toggle Device Toolbar** (icon phone/tablet)
4. Pilih device atau atur ukuran manual

### 2. Breakpoints yang Harus Ditest

| Device Type | Width | Test Points |
|-------------|-------|-------------|
| Desktop Large | 1920px | Full layout, 3 column grid |
| Desktop | 1280px | Standard desktop view |
| Laptop | 1024px | Transition point |
| Tablet | 768px | 2 column grid, menu changes |
| Mobile Large | 425px | Single column, hamburger menu |
| Mobile | 375px | iPhone SE size |
| Mobile Small | 320px | Smallest phones |

### 3. Halaman yang Harus Ditest

#### Frontend Pages:

**Homepage (/)**
- [ ] Hero section responsive
- [ ] Featured villas grid (3→2→1 columns)
- [ ] Destinations grid (6→3→2 columns)
- [ ] Testimonials grid (2→1 columns)
- [ ] Mobile menu toggle works
- [ ] Footer stacks properly

**Destinations (/destinations)**
- [ ] Filter sidebar stacks on mobile
- [ ] Villa grid responsive (3→2→1)
- [ ] Pagination works on mobile
- [ ] Search filters accessible

**Villa Detail (/villas/{villa})**
- [ ] Hero image scales properly
- [ ] Villa name not cut off
- [ ] Navbar visible (not hidden)
- [ ] Tabs work on mobile
- [ ] Inquiry form accessible
- [ ] Sidebar stacks on mobile
- [ ] Images in gallery responsive

**About (/about)**
- [ ] Content readable on mobile
- [ ] Stats grid responsive (4→2→1)
- [ ] Values grid responsive (3→1)
- [ ] CTA buttons stack on mobile

**Contact (/contact)**
- [ ] Form usable on mobile
- [ ] Contact info readable
- [ ] Map placeholder responsive

#### Admin Panel (/admin):

**Login Page**
- [ ] Form centered on mobile
- [ ] Input fields full width

**Dashboard**
- [ ] Stats cards responsive (4→2→1)
- [ ] Tables scroll horizontally on mobile
- [ ] Sidebar collapsible on mobile

**Villa Management**
- [ ] Table scrollable on mobile
- [ ] Forms responsive
- [ ] Bedroom configs stack on mobile

**Inquiries**
- [ ] List view readable
- [ ] Detail view stacks properly

### 4. Common Issues to Check

#### Mobile Issues:
- [ ] Text too small (should be ≥14px)
- [ ] Buttons too small (should be ≥44px touch target)
- [ ] Horizontal scroll (should not exist)
- [ ] Content cut off
- [ ] Images not loading
- [ ] Menu not working

#### Tablet Issues:
- [ ] Grid layout awkward
- [ ] Too much white space
- [ ] Navigation confusing

#### Desktop Issues:
- [ ] Content too wide to read
- [ ] Images pixelated
- [ ] Spacing too large

### 5. Performance Testing

#### Mobile Performance:
1. Open DevTools → Lighthouse tab
2. Select "Mobile"
3. Check "Performance"
4. Run audit

**Target Scores:**
- Performance: ≥80
- Accessibility: ≥90
- Best Practices: ≥90
- SEO: ≥90

### 6. Real Device Testing

Jika ada akses ke device fisik:
- [ ] Test di iPhone
- [ ] Test di Android phone
- [ ] Test di iPad/tablet
- [ ] Test di berbagai browser (Chrome, Safari, Firefox)

---

## ✅ Responsive Checklist Summary

### Navigation
- [x] Desktop menu (horizontal)
- [x] Mobile menu (hamburger + dropdown)
- [x] Menu toggle JavaScript works
- [x] Active state highlights

### Layout
- [x] Container max-width (7xl = 1280px)
- [x] Responsive padding (mx-4 → md:mx-12)
- [x] Grid responsive (3→2→1 columns)
- [x] Flex wrap on mobile

### Typography
- [x] Responsive font sizes
- [x] Readable line lengths
- [x] Proper line heights

### Images
- [x] Responsive sizing
- [x] Object-cover for consistency
- [x] Lazy loading implemented

### Forms
- [x] Input fields full width on mobile
- [x] Touch-friendly buttons (≥44px)
- [x] Validation messages visible

### Tables
- [x] Horizontal scroll on mobile
- [x] Responsive headers

### Buttons & CTAs
- [x] Full width on mobile
- [x] Proper spacing
- [x] Hover states work

---

## 🎯 Test Results Template

| Page | Desktop | Tablet | Mobile | Notes |
|------|---------|--------|--------|-------|
| Home | ⬜ | ⬜ | ⬜ | |
| Destinations | ⬜ | ⬜ | ⬜ | |
| Villa Detail | ⬜ | ⬜ | ⬜ | |
| About | ⬜ | ⬜ | ⬜ | |
| Contact | ⬜ | ⬜ | ⬜ | |
| Admin Login | ⬜ | ⬜ | ⬜ | |
| Admin Dashboard | ⬜ | ⬜ | ⬜ | |

**Legend:**
- ✅ Pass
- ⚠️ Minor issues
- ❌ Needs fix
- ⬜ Not tested

---

**Testing Date:** ___________  
**Tested By:** ___________  
**Overall Status:** ⬜ Pass ⬜ Needs Work
