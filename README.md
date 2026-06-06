from pathlib import Path
import fitz  # PyMuPDF

outdir = Path("/mnt/data/food_ordering_readme_assets")
outdir.mkdir(exist_ok=True)

# Pages 53-56 in document numbering correspond roughly to indices 52-55
saved = []
for idx in [52, 53, 54, 55]:
    if idx < len(doc):
        page = doc[idx]
        pix = page.get_pixmap(matrix=fitz.Matrix(2, 2), alpha=False)
        fname = outdir / f"screenshot_page_{idx+1}.png"
        pix.save(str(fname))
        saved.append(fname.name)

readme = f"""# Online Food Ordering System

## Project Overview
Online Food Ordering System is a web-based application that allows customers to browse food menus, register/login, add dishes to a cart, place orders, and make payments online.

## Features
- User Registration & Login
- Menu Browsing
- Search & Category Filtering
- Cart Management
- Order Placement
- Payment Options (COD, UPI, Card)
- Admin Dashboard
- Order Management

## Technology Stack
### Frontend
- HTML5
- CSS3
- Bootstrap

### Backend
- PHP

### Database
- MySQL

## Screenshots

### Home / Result Screens
![Screenshot 1](food_ordering_readme_assets/{saved[0] if len(saved)>0 else ""})

### Registration / Login
![Screenshot 2](food_ordering_readme_assets/{saved[1] if len(saved)>1 else ""})

### Menu / Admin Dashboard
![Screenshot 3](food_ordering_readme_assets/{saved[2] if len(saved)>2 else ""})

### Database & Reports
![Screenshot 4](food_ordering_readme_assets/{saved[3] if len(saved)>3 else ""})

## Modules
1. User Module
2. Menu Module
3. Cart Module
4. Order Module
5. Payment Module
6. Admin Module

## Future Scope
- AI Chatbot Support
- Real-Time Tracking
- Loyalty Programs
- Discount Coupons
- Advanced Analytics

## Author
Tanvi Madhukar Mokal
B.Sc. Information Technology
"""

readme_path = "/mnt/data/README.md"
Path(readme_path).write_text(readme, encoding="utf-8")

print({"readme": readme_path, "assets_dir": str(outdir), "images": saved})
