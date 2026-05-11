# KomuniTech Design System & UI/UX Overhaul

## Overview
This document outlines the modern, responsive design system implemented across the KomuniTech platform. All pages should be progressively refactored to use these components and tokens for consistency, accessibility, and professional appearance.

---

## Color Palette

### Primary Colors (Blue)
Used for CTAs, navigation highlights, and primary actions.
- `primary-50`: `#f0f7ff` - Very light backgrounds
- `primary-600`: `#0284c7` - Main action color
- `primary-700`: `#0369a1` - Hover state
- `primary-900`: `#0c3d66` - Text/headings

### Status Colors
- **Success** (Green): Approvals, confirmations, active states
- **Error** (Red): Deletions, rejections, errors
- **Warning** (Orange/Yellow): Pending, alerts, caution
- **Info** (Cyan): Informational messages

### Neutral Colors
- `neutral-50` to `neutral-950`: Text, borders, backgrounds
- Use `neutral-900` for primary text
- Use `neutral-700` for secondary text
- Use `neutral-400` for subtle text

---

## Typography

### Font
- **Family**: Quicksand (Google Fonts)
- **Weights**: 400 (normal), 600 (semibold), 700 (bold)

### Sizes
- `text-xs`: 12px - Small labels, hints
- `text-sm`: 14px - Secondary text, table data
- `text-base`: 16px - Body text, default
- `text-lg`: 18px - Large body text
- `text-xl`: 20px - Section titles
- `text-2xl`: 24px - Card titles
- `text-3xl`: 30px - Page headings
- `text-4xl`: 36px - Large headings

---

## Spacing Scale
- `sm` (8px): Compact spacing
- `md` (16px): Default spacing
- `lg` (24px): Loose spacing
- `xl` (32px): Very loose spacing

---

## Reusable Components

### Button Component
```blade
<!-- Primary Button -->
<x-button variant="primary" size="md">Click Me</x-button>

<!-- Other Variants -->
<x-button variant="secondary">Secondary</x-button>
<x-button variant="success">Success</x-button>
<x-button variant="error">Delete</x-button>
<x-button variant="warning">Caution</x-button>
<x-button variant="ghost">Link-like</x-button>

<!-- With Icon -->
<x-button variant="primary" icon="<i class='fas fa-save'></i>">Save</x-button>

<!-- Full Width -->
<x-button fullWidth>Submit</x-button>

<!-- Loading State -->
<x-button loading>Processing...</x-button>

<!-- Disabled -->
<x-button disabled>Not Available</x-button>
```

### Card Component
```blade
<!-- Basic Card -->
<x-card>
    <h2>Card Title</h2>
    <p>Card content goes here.</p>
</x-card>

<!-- With Shadow -->
<x-card shadow="lg">
    Content with large shadow
</x-card>

<!-- With Border -->
<x-card shadow="md" padding="lg" border>
    Bordered content card
</x-card>
```

### Input Component
```blade
<!-- Text Input -->
<x-input 
    name="username" 
    label="Username" 
    placeholder="Enter username"
    required
/>

<!-- With Error -->
<x-input 
    name="email" 
    label="Email"
    error="Please enter a valid email"
/>

<!-- With Hint -->
<x-input 
    name="age" 
    label="Age" 
    hint="Must be 18 or older"
/>
```

### Alert Component
```blade
<!-- Success Alert -->
<x-alert variant="success">
    <div class="font-medium">Success!</div>
    <div class="text-sm">Operation completed successfully.</div>
</x-alert>

<!-- Error Alert -->
<x-alert variant="error">
    <div class="font-medium">Error</div>
    <div class="text-sm">Something went wrong.</div>
</x-alert>

<!-- Warning Alert -->
<x-alert variant="warning">
    Action required before proceeding.
</x-alert>

<!-- Dismissible -->
<x-alert variant="info" dismissible>
    This alert can be closed.
</x-alert>
```

### Badge Component
```blade
<!-- Active Status -->
<x-badge variant="success">Active</x-badge>

<!-- Pending Status -->
<x-badge variant="warning">Pending</x-badge>

<!-- Error Status -->
<x-badge variant="error">Rejected</x-badge>

<!-- Sizes -->
<x-badge variant="primary" size="sm">Small</x-badge>
<x-badge variant="primary" size="md">Medium</x-badge>
<x-badge variant="primary" size="lg">Large</x-badge>
```

### Table Components
```blade
<x-table>
    <x-table-head>
        <x-table-cell-head>Name</x-table-cell-head>
        <x-table-cell-head align="right">Price</x-table-cell-head>
        <x-table-cell-head align="center">Status</x-table-cell-head>
        <x-table-cell-head align="right">Actions</x-table-cell-head>
    </x-table-head>
    <x-table-body>
        @foreach($items as $item)
            <x-table-row>
                <x-table-cell>{{ $item->name }}</x-table-cell>
                <x-table-cell align="right">₱{{ number_format($item->price, 2) }}</x-table-cell>
                <x-table-cell align="center">
                    <x-badge variant="success">Active</x-badge>
                </x-table-cell>
                <x-table-cell align="right">
                    <a href="#" class="text-primary-600 hover:text-primary-700">Edit</a>
                </x-table-cell>
            </x-table-row>
        @endforeach
    </x-table-body>
</x-table>
```

---

## Page Structure Pattern

### Header Section
```blade
@section('header')
    <header class="bg-gradient-to-r from-primary-50 to-primary-100 border-b border-primary-200">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <h1 class="text-3xl font-bold text-primary-900">
                <i class="fas fa-icon-name mr-3"></i>Page Title
            </h1>
            <p class="text-primary-700 mt-1">Subtitle or description</p>
        </div>
    </header>
@endsection
```

### Content Section
```blade
@section('content')
    <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Alerts at top -->
        @if(session('success'))
            <x-alert variant="success" class="mb-6">
                {{ session('success') }}
            </x-alert>
        @endif

        <!-- Main content cards -->
        <x-card class="border mb-6">
            <!-- Content -->
        </x-card>
    </div>
@endsection
```

---

## Icon Library
Using **Font Awesome 6.4.0** for all icons. Already loaded in the main layout.

### Common Icons
- `fas fa-home` - Home/Dashboard
- `fas fa-file-circle-plus` - New document
- `fas fa-tasks` - Task/Request management
- `fas fa-bell` - Notifications
- `fas fa-edit` - Edit action
- `fas fa-trash` - Delete action
- `fas fa-save` - Save action
- `fas fa-check-circle` - Success/Complete
- `fas fa-times-circle` - Error/Rejected
- `fas fa-hourglass-half` - Pending
- `fas fa-download` - Download
- `fas fa-print` - Print
- `fas fa-pdf` - PDF file
- `fas fa-user-circle` - User profile
- `fas fa-sign-out-alt` - Logout
- `fas fa-plus` - Add/Create
- `fas fa-arrow-right` - Navigate/Next
- `fas fa-info-circle` - Information
- `fas fa-lightbulb` - Tip/Suggestion
- `fas fa-peso-sign` - Currency/Pricing
- `fas fa-chart-line` - Analytics/Dashboard

---

## Responsive Design Guidelines

### Breakpoints
- Mobile: `< 640px` (Tailwind `sm`)
- Tablet: `640px - 1024px` (Tailwind `md` and `lg`)
- Desktop: `> 1024px` (Tailwind `xl`)

### Mobile-First Approach
```blade
<!-- Stack on mobile, side-by-side on desktop -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div>Column 1</div>
    <div>Column 2</div>
    <div>Column 3</div>
</div>

<!-- Hide on mobile, show on desktop -->
<div class="hidden md:block">Desktop Only</div>

<!-- Show on mobile, hide on desktop -->
<div class="md:hidden">Mobile Only</div>
```

### Container Sizes
```blade
<!-- Full width with padding -->
<div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
    Content
</div>

<!-- Narrow container (good for forms) -->
<div class="max-w-2xl mx-auto">
    Form content
</div>

<!-- Wide container -->
<div class="max-w-6xl mx-auto">
    Dashboard content
</div>
```

---

## Migration Checklist for Existing Pages

### Before Refactoring
- [ ] Take screenshot of current page
- [ ] Note all elements: buttons, forms, tables, alerts
- [ ] Identify custom styles that should be preserved

### During Refactoring
- [ ] Replace header with design system header pattern
- [ ] Convert buttons: `class="px-6 py-2 bg-blue-600..."` → `<x-button>`
- [ ] Convert cards: `div class="shadow-lg rounded-lg..."` → `<x-card>`
- [ ] Convert inputs: `input class="border rounded..."` → `<x-input>`
- [ ] Replace tables with `<x-table>` components
- [ ] Update all text colors to use neutral palette
- [ ] Replace custom alerts with `<x-alert>`
- [ ] Add Font Awesome icons where appropriate
- [ ] Test responsiveness on mobile/tablet/desktop

### After Refactoring
- [ ] Verify all buttons work and have consistent styling
- [ ] Check form validation and error messages
- [ ] Test responsive layout on all breakpoints
- [ ] Ensure navigation highlights are correct
- [ ] Verify alerts display and dismiss properly
- [ ] Check accessibility (keyboard navigation, ARIA labels)
- [ ] Test in different browsers

---

## Common Refactoring Examples

### Before: Old Button Styling
```blade
<button class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">Save</button>
```

### After: New Button Component
```blade
<x-button variant="success">Save</x-button>
```

---

### Before: Old Card
```blade
<div class="bg-white shadow-md rounded-lg p-6 border border-gray-200">
    <h2 class="text-xl font-bold mb-4">Title</h2>
    <p>Content</p>
</div>
```

### After: New Card Component
```blade
<x-card class="border" shadow="md">
    <h2 class="text-xl font-bold mb-4">Title</h2>
    <p>Content</p>
</x-card>
```

---

### Before: Old Alert
```blade
<div class="p-4 bg-red-100 text-red-700 rounded border border-red-300">
    {{ $error }}
</div>
```

### After: New Alert Component
```blade
<x-alert variant="error">{{ $error }}</x-alert>
```

---

## Accessibility Standards

### Guidelines
- [ ] All interactive elements are keyboard accessible
- [ ] Color is not the only means of conveying information
- [ ] Sufficient color contrast (WCAG AA)
- [ ] Form inputs have associated labels
- [ ] Error messages are clearly marked
- [ ] Icons include title attributes or ARIA labels
- [ ] Focus states are visible
- [ ] Loading states are communicated to screen readers

### Testing
```bash
# Run accessibility audit
# Use browser DevTools → Lighthouse → Accessibility
# Check all forms work with Tab key navigation
# Test with screen reader (NVDA, JAWS, VoiceOver)
```

---

## Implementation Priority

### Phase 1 (Highest Priority)
- [ ] Admin dashboards (impact: high, complexity: low)
- [ ] Navigation and layout (impact: very high, complexity: low)
- [ ] Document type management pages
- [ ] Document request management pages

### Phase 2 (Medium Priority)
- [ ] User dashboards and forms
- [ ] Announcements pages
- [ ] Barangay management pages

### Phase 3 (Lower Priority)
- [ ] Authentication pages
- [ ] Profile pages
- [ ] Additional utilities and edge cases

---

## Questions & Troubleshooting

### Q: My custom styles aren't showing
A: Ensure you're using the component props instead of adding classes directly. For exceptions, use the `{{ $attributes }}` merge in components.

### Q: How do I add custom icons?
A: Font Awesome is already loaded. Use `<i class="fas fa-icon-name"></i>` anywhere.

### Q: How do I override component colors?
A: Use Tailwind's color classes on the components: `<x-button class="bg-purple-600">` or create a new variant in the component file.

### Q: How do I make a responsive layout?
A: Use Tailwind's breakpoint prefixes: `grid-cols-1 md:grid-cols-2 lg:grid-cols-3`

---

## Resources

- [Tailwind CSS Documentation](https://tailwindcss.com/docs)
- [Font Awesome Icons](https://fontawesome.com/icons)
- [WCAG Accessibility Guidelines](https://www.w3.org/WAI/WCAG21/quickref/)
- [Blade Component Documentation](https://laravel.com/docs/blade)

---

## Contact & Support

For questions about the design system implementation, consult the refactored pages as examples:
- **Admin Document Types**: `/resources/views/admin/document_types/index.blade.php`
- **Admin Dashboard**: `/resources/views/admin/dashboard.blade.php`
- **Navigation**: `/resources/views/layouts/navigation.blade.php`
- **Components**: `/resources/views/components/`
