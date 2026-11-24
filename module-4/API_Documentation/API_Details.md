# Matrimony (Module 4) – API Details

**Base URL:** `https://eliteinteriorstudios.com/peoplelink/matrimoney/api.php` (local: `http://localhost/peoplelink/matrimoney/api.php`)

## Common rules

- **Required headers:** `Accept: application/json`. For JSON bodies `Content-Type: application/json`; for files `multipart/form-data`. Session cookie (`PHPSESSID`) for logged-in calls.
- **CSRF:** every POST except login/register/logout must include `csrf` (from `session`). Wrong/expired token → **403 CSRF_INVALID** (check the `code` field, not only the HTTP status).
- **Community:** members are locked to their own community on the server; `c=<slug>` is only used for visitors. Another community's record → **403 COMMUNITY_MISMATCH**.
- **Common errors:** 401 AUTH_REQUIRED · 404 NOT_FOUND / unknown action · 405 POST required · 403 CSRF_INVALID · 500 SERVER_ERROR (logged, generic message to user).
- All database access uses PDO prepared statements.

---

## register

| | |
|---|---|
| Category | Authentication |
| Endpoint | `/peoplelink/matrimoney/api.php?action=register` |
| Method | POST |
| Purpose | Create a member account and log in (same session as website). |
| Auth | Not required |
| Headers | Accept: application/json |
| Query / extra params | - |
| Status | Existing |
| Tables | users, user_sessions |
| Validation | name required; valid email; password ≥ 6; confirm must match |
| Frontend | matrimoney/signup.php (Register free on Matrimony home) |

**Request body**

```json
{
  "name": "Asha T",
  "email": "asha@example.com",
  "phone": "9876500001",
  "password": "secret123",
  "confirm": "secret123"
}
```

**Success (200)**

```json
{
  "ok": true,
  "message": "Account created.",
  "csrf": "32ac…",
  "logged_in": true,
  "user": {
    "id": 23,
    "name": "Asha T",
    "email": "asha@example.com",
    "role": "member"
  },
  "community": {
    "id": 1,
    "name": "Arya Vysya",
    "slug": "aryavysya"
  },
  "profile": null
}
```

**Errors:** 400 VALIDATION_ERROR, 409 EMAIL_EXISTS

---

## login

| | |
|---|---|
| Category | Authentication |
| Endpoint | `/peoplelink/matrimoney/api.php?action=login` |
| Method | POST |
| Purpose | Log in with email + password. Max 3 active devices. |
| Auth | Not required |
| Headers | Accept: application/json |
| Query / extra params | - |
| Status | Existing |
| Tables | users, user_sessions, api_login_attempts |
| Validation | 8 failed attempts / 10 min per email or IP are blocked |
| Frontend | matrimoney/login.php (Login buttons) |

**Request body**

```json
{
  "email": "asha@example.com",
  "password": "secret123",
  "logout_oldest": false
}
```

**Success (200)**

```json
{
  "ok": true,
  "message": "Logged in.",
  "csrf": "…",
  "logged_in": true,
  "user": {
    "id": 23,
    "name": "Asha T",
    "role": "member"
  },
  "community": {
    "id": 1,
    "slug": "aryavysya"
  },
  "profile": {
    "id": 8,
    "code": "PL-MAT-1008",
    "status": "approved"
  }
}
```

**Errors:** 400 VALIDATION_ERROR, 401 INVALID_CREDENTIALS, 429 RATE_LIMITED, device-limit error when 3 devices are active

---

## logout

| | |
|---|---|
| Category | Authentication |
| Endpoint | `/peoplelink/matrimoney/api.php?action=logout` |
| Method | POST |
| Purpose | End the current session. |
| Auth | Not required |
| Headers | Accept: application/json |
| Query / extra params | - |
| Status | Existing |
| Tables | user_sessions |
| Validation | - |
| Frontend | Header › Logout |

**Request body**

```json
{}
```

**Success (200)**

```json
{
  "ok": true,
  "message": "Logged out."
}
```

**Errors:** -

---

## session

| | |
|---|---|
| Category | Authentication |
| Endpoint | `/peoplelink/matrimoney/api.php?action=session` |
| Method | GET |
| Purpose | Current user, community, matrimony profile and CSRF token. |
| Auth | Not required |
| Headers | Accept: application/json |
| Query / extra params | c (community slug, optional) |
| Status | Existing |
| Tables | users, communities, matrimony_profiles |
| Validation | - |
| Frontend | Used by Flutter app; web pages get the token server-side |

**Success (200)**

```json
{
  "ok": true,
  "csrf": "…",
  "logged_in": true,
  "user": {
    "id": 23
  },
  "community": {
    "id": 1,
    "name": "Arya Vysya",
    "slug": "aryavysya"
  },
  "profile": {
    "id": 8,
    "code": "PL-MAT-1008",
    "name": "Asha T",
    "status": "approved"
  }
}
```

**Errors:** -

---

## create_profile

| | |
|---|---|
| Category | Profile |
| Endpoint | `/peoplelink/matrimoney/api.php?action=create_profile` |
| Method | POST |
| Purpose | Create the member's matrimony profile (status pending until admin approval). Optional photos[] files. |
| Auth | Logged-in member (session cookie) |
| Headers | Accept: application/json; csrf in body |
| Query / extra params | multipart allowed |
| Status | Updated (module-4) |
| Tables | matrimony_profiles, matrimony_photos, matrimony_preferences, matrimony_notifications |
| Validation | Required: full_name, gender (Male/Female), date_of_birth (YYYY-MM-DD, age 18–80), marital_status, state, city, qualification, profession, mobile (10 digits, starts 6-9), about_me (≥ 20 chars). email must be valid. brothers/sisters 0–15. Age is calculated from date_of_birth. |
| Frontend | profile-form.php (create mode) |

**Request body**

```json
{
  "full_name": "Asha T",
  "gender": "Female",
  "date_of_birth": "1998-05-01",
  "height": "5' 3\"",
  "marital_status": "Never Married",
  "mother_tongue": "Telugu",
  "state": "Telangana",
  "city": "Hyderabad",
  "qualification": "Post Graduate",
  "profession": "Teacher",
  "mobile": "9876500001",
  "email": "asha@example.com",
  "father_name": "Ravi",
  "about_me": "I am a teacher who loves music and travel."
}
```

**Success (200)**

```json
{
  "ok": true,
  "id": 8,
  "profile_code": "PL-MAT-1008",
  "message": "Profile submitted for approval."
}
```

**Errors:** 400 VALIDATION_ERROR, 400 UNDERAGE, 401 AUTH_REQUIRED, 400 'You already have a profile in this community.'

---

## update_profile

| | |
|---|---|
| Category | Profile |
| Endpoint | `/peoplelink/matrimoney/api.php?action=update_profile` |
| Method | POST |
| Purpose | Edit own profile. An approved profile goes back to pending (re-approval). Gender cannot be changed. |
| Auth | Logged-in member (session cookie) |
| Headers | Accept: application/json; csrf in body |
| Query / extra params | - |
| Status | Updated (module-4) |
| Tables | matrimony_profiles |
| Validation | Same rules as create, but only for fields that are sent. |
| Frontend | profile-form.php (edit mode) |

**Request body**

```json
{
  "profession": "Senior Teacher",
  "city": "Hyderabad",
  "about_me": "Updated about text with enough length."
}
```

**Success (200)**

```json
{
  "ok": true,
  "id": 8,
  "message": "Profile updated and sent for re-approval."
}
```

**Errors:** 400 VALIDATION_ERROR, 400 UNDERAGE, 400 'Create your profile first.'

---

## me

| | |
|---|---|
| Category | Profile |
| Endpoint | `/peoplelink/matrimoney/api.php?action=me` |
| Method | GET |
| Purpose | Own profile with completion %, dashboard counts and package status. |
| Auth | Logged-in member (session cookie) |
| Headers | Accept: application/json |
| Query / extra params | - |
| Status | Updated (module-4) |
| Tables | matrimony_profiles, matrimony_photos, matrimony_preferences, matrimony_interests, matrimony_saved, matrimony_profile_views, matrimony_contact_requests, user_notifications, user_packages |
| Validation | - |
| Frontend | my-profile.php, photos.php |

**Success (200)**

```json
{
  "ok": true,
  "profile": {
    "id": 8,
    "code": "PL-MAT-1008",
    "name": "Asha T",
    "status": "approved",
    "is_active": true,
    "completion": {
      "percent": 90,
      "missing": [
        "Photo"
      ]
    },
    "phone": "9876500001",
    "photos": []
  },
  "stats": {
    "interests_received_pending": 1,
    "interests_sent": 1,
    "interests_accepted": 1,
    "saved": 1,
    "visitors_30d": 2,
    "contact_requests_pending": 0,
    "notifications_unread": 1
  },
  "entitlement": {
    "active": false,
    "packages": [],
    "remaining": 0,
    "expires_at": null
  }
}
```

**Errors:** 401 AUTH_REQUIRED

---

## profile

| | |
|---|---|
| Category | Profile |
| Endpoint | `/peoplelink/matrimoney/api.php?action=profile` |
| Method | GET |
| Purpose | View one profile. Members see only their community. Adds match %, contact-request state; logs a profile visit. |
| Auth | Optional – works for visitors; more data when logged in |
| Headers | Accept: application/json |
| Query / extra params | id or code |
| Status | Updated (module-4) |
| Tables | matrimony_profiles, matrimony_photos, matrimony_preferences, matrimony_interests, matrimony_contact_requests, matrimony_saved, matrimony_blocks, matrimony_profile_views |
| Validation | Only approved + active profiles (own profile always). Phone/email only when contact_visible. Photos follow the owner's photo privacy. |
| Frontend | profile.php |

**Success (200)**

```json
{
  "ok": true,
  "profile": {
    "id": 9,
    "code": "PL-MAT-1009",
    "name": "Bharat T",
    "age": 31,
    "gender": "Male",
    "education": "Graduate",
    "profession": "Software Engineer",
    "city": "Hyderabad",
    "photo": null,
    "photos": [],
    "preferences": {},
    "saved": false,
    "blocked": false,
    "is_own": false,
    "interest": {
      "id": 9,
      "status": "accepted",
      "direction": "sent"
    },
    "contact_visible": true,
    "phone": "9876500002",
    "email": "",
    "match_percent": 100,
    "contact_request": null
  }
}
```

**Errors:** 404 PROFILE_NOT_FOUND, 403 COMMUNITY_MISMATCH

---

## profile_set_active

| | |
|---|---|
| Category | Profile |
| Endpoint | `/peoplelink/matrimoney/api.php?action=profile_set_active` |
| Method | POST |
| Purpose | Hide (0) or show (1) own profile in search. |
| Auth | Logged-in member (session cookie) |
| Headers | Accept: application/json; csrf in body |
| Query / extra params | - |
| Status | Existing |
| Tables | matrimony_profiles |
| Validation | - |
| Frontend | my-profile.php › Profile visibility |

**Request body**

```json
{
  "active": 0
}
```

**Success (200)**

```json
{
  "ok": true,
  "message": "Your profile is hidden. Reactivate it any time from My Profile.",
  "is_active": false
}
```

**Errors:** 400 'Create your profile first.'

---

## matrimony_dashboard

| | |
|---|---|
| Category | Profile |
| Endpoint | `/peoplelink/matrimoney/api.php?action=matrimony_dashboard` |
| Method | GET |
| Purpose | Counts, completion % and package status for the dashboard (lighter than `me`). |
| Auth | Logged-in member (session cookie) |
| Headers | Accept: application/json |
| Query / extra params | - |
| Status | New |
| Tables | same as `me` |
| Validation | - |
| Frontend | Flutter dashboard (web uses `me`) |

**Success (200)**

```json
{
  "ok": true,
  "stats": {
    "interests_received_pending": 1
  },
  "completion": {
    "percent": 90,
    "missing": [
      "Photo"
    ]
  },
  "status": "approved",
  "entitlement": {
    "active": false
  }
}
```

**Errors:** 400 PROFILE_REQUIRED

---

## upload_photos

| | |
|---|---|
| Category | Photos |
| Endpoint | `/peoplelink/matrimoney/api.php?action=upload_photos` |
| Method | POST |
| Purpose | Upload photos (multipart, field photos[]). New photos are pending admin approval; first photo becomes main. |
| Auth | Logged-in member (session cookie) |
| Headers | Accept: application/json; csrf in body |
| Query / extra params | multipart/form-data |
| Status | Existing |
| Tables | matrimony_photos |
| Validation | JPG/PNG/WEBP, ≤ 5 MB, ≤ 6 photos, real image check; resized to 1600px + 400px thumbnail |
| Frontend | photos.php, profile-form.php |

**Request body**

```json
{
  "photos[]": "(files)"
}
```

**Success (200)**

```json
{
  "ok": true,
  "message": "1 photo uploaded for approval.",
  "added": 1,
  "photos": [
    {
      "photo_id": 10,
      "thumbnail_url": "…/uploads/photos/th_11-ab12.jpg",
      "full_url": "…/uploads/photos/11-ab12.jpg",
      "is_primary": 1,
      "approval_status": "pending"
    }
  ]
}
```

**Errors:** 400 'Maximum 6 photos allowed.', 400 'Photo must be JPG, PNG or WEBP up to 5 MB.'

---

## delete_photo

| | |
|---|---|
| Category | Photos |
| Endpoint | `/peoplelink/matrimoney/api.php?action=delete_photo` |
| Method | POST |
| Purpose | Delete own photo (files removed). |
| Auth | Logged-in member (session cookie) |
| Headers | Accept: application/json; csrf in body |
| Query / extra params | - |
| Status | Existing |
| Tables | matrimony_photos |
| Validation | Photo must belong to own profile |
| Frontend | photos.php |

**Request body**

```json
{
  "photo_id": 10
}
```

**Success (200)**

```json
{
  "ok": true,
  "message": "Photo removed.",
  "photos": []
}
```

**Errors:** 400 'Photo not found.'

---

## set_primary_photo

| | |
|---|---|
| Category | Photos |
| Endpoint | `/peoplelink/matrimoney/api.php?action=set_primary_photo` |
| Method | POST |
| Purpose | Make a photo the main photo. |
| Auth | Logged-in member (session cookie) |
| Headers | Accept: application/json; csrf in body |
| Query / extra params | - |
| Status | Existing |
| Tables | matrimony_photos |
| Validation | Photo must belong to own profile |
| Frontend | photos.php |

**Request body**

```json
{
  "photo_id": 10
}
```

**Success (200)**

```json
{
  "ok": true,
  "message": "Primary photo updated.",
  "photos": []
}
```

**Errors:** 400 'Photo not found.'

---

## save_preferences

| | |
|---|---|
| Category | Partner Preferences |
| Endpoint | `/peoplelink/matrimoney/api.php?action=save_preferences` |
| Method | POST |
| Purpose | Add / update partner preferences (used for match %). |
| Auth | Logged-in member (session cookie) |
| Headers | Accept: application/json; csrf in body |
| Query / extra params | - |
| Status | Existing |
| Tables | matrimony_preferences |
| Validation | Ages 18–80, from ≤ to (checked in browser) |
| Frontend | preferences.php |

**Request body**

```json
{
  "age_min": 25,
  "age_max": 33,
  "partner_location": "Hyderabad",
  "partner_education[]": [
    "Graduate"
  ],
  "partner_profession": "Engineer",
  "partner_marital_status[]": [
    "Never Married"
  ],
  "partner_mother_tongue": "Telugu",
  "other_preferences": "Vegetarian family"
}
```

**Success (200)**

```json
{
  "ok": true,
  "message": "Partner preferences saved."
}
```

**Errors:** 400 'Create your profile first.'

---

## (read) me / profile

| | |
|---|---|
| Category | Partner Preferences |
| Endpoint | `/peoplelink/matrimoney/api.php?action=(read)` |
| Method | GET |
| Purpose | Preferences are returned inside `me` and `profile` as `preferences`. |
| Auth | Logged-in member (session cookie) |
| Headers | Accept: application/json |
| Query / extra params | - |
| Status | Existing |
| Tables | matrimony_preferences |
| Validation | - |
| Frontend | preferences.php, profile.php |

**Success (200)**

```json
{
  "preferences": {
    "age_min": 25,
    "age_max": 33,
    "location": "Hyderabad",
    "education": "Graduate",
    "profession": "Engineer",
    "marital_status": "Never Married",
    "other": ""
  }
}
```

**Errors:** -

---

## search

| | |
|---|---|
| Category | Search |
| Endpoint | `/peoplelink/matrimoney/api.php?action=search` |
| Method | GET |
| Purpose | Search approved profiles of the community. Logged-in members see only the opposite gender, never blocked profiles. Adds match %. |
| Auth | Optional – works for visitors; more data when logged in |
| Headers | Accept: application/json |
| Query / extra params | q, gender, min_age, max_age (or age=26-30), marital_status, education, profession, country, state, district, city, min_height, max_height, sort (recent|age-asc|age-desc|location|education|profession), page, per (max 100) |
| Status | Updated (module-4) |
| Tables | matrimony_profiles, matrimony_photos, matrimony_saved, matrimony_blocks, matrimony_preferences, communities |
| Validation | Text filters use LIKE with prepared statements |
| Frontend | search.php, index.php |

**Success (200)**

```json
{
  "ok": true,
  "total": 3,
  "page": 1,
  "per": 12,
  "total_pages": 1,
  "profiles": [
    {
      "id": 9,
      "code": "PL-MAT-1009",
      "name": "Bharat T",
      "age": 31,
      "gender": "Male",
      "marital": "Never Married",
      "education": "Graduate",
      "profession": "Software Engineer",
      "city": "Hyderabad",
      "photo": null,
      "saved": true,
      "match_percent": 100
    }
  ]
}
```

**Errors:** 400 'Select a community first.' (visitors without community)

---

## matrimony_filters

| | |
|---|---|
| Category | Search |
| Endpoint | `/peoplelink/matrimoney/api.php?action=matrimony_filters` |
| Method | GET |
| Purpose | Real dropdown values from approved profiles of the community. |
| Auth | Not required |
| Headers | Accept: application/json |
| Query / extra params | - |
| Status | New |
| Tables | matrimony_profiles |
| Validation | - |
| Frontend | search.php, index.php |

**Success (200)**

```json
{
  "ok": true,
  "filters": {
    "education": [
      "Graduate",
      "Post Graduate"
    ],
    "profession": [
      "Manager"
    ],
    "city": [
      "Hyderabad"
    ],
    "state": [
      "Telangana"
    ],
    "country": [
      "India"
    ],
    "marital_status": [
      "Never Married"
    ],
    "mother_tongue": [
      "Telugu"
    ],
    "age_range": {
      "min_age": 26,
      "max_age": 31
    },
    "sort": {
      "recent": "Newest first"
    }
  }
}
```

**Errors:** -

---

## matrimony_visitors

| | |
|---|---|
| Category | Search |
| Endpoint | `/peoplelink/matrimoney/api.php?action=matrimony_visitors` |
| Method | GET |
| Purpose | Approved members who viewed my profile (one row per member). |
| Auth | Logged-in member (session cookie) |
| Headers | Accept: application/json |
| Query / extra params | page, per |
| Status | New |
| Tables | matrimony_profile_views, matrimony_profiles |
| Validation | Visits are logged only when the viewer's profile is approved |
| Frontend | visitors.php |

**Success (200)**

```json
{
  "ok": true,
  "profiles": [
    {
      "id": 8,
      "code": "PL-MAT-1008",
      "name": "Asha T",
      "last_viewed_at": "2026-11-15 17:32:45",
      "views": 2
    }
  ],
  "total": 1,
  "page": 1,
  "per": 12,
  "total_pages": 1
}
```

**Errors:** 400 PROFILE_REQUIRED

---

## send_interest

| | |
|---|---|
| Category | Interest Management |
| Endpoint | `/peoplelink/matrimoney/api.php?action=send_interest` |
| Method | POST |
| Purpose | Send interest to a profile (+ in-app/push notification to receiver). |
| Auth | Logged-in member (session cookie) |
| Headers | Accept: application/json; csrf in body |
| Query / extra params | - |
| Status | Updated (module-4) |
| Tables | matrimony_interests, user_notifications, matrimony_notifications |
| Validation | Own profile approved; target approved, active, same community, opposite gender, not blocked either way, receiveInterests on; message ≤ 1000 |
| Frontend | profile.php |

**Request body**

```json
{
  "profile_id": 9,
  "message": "Hi, I liked your profile."
}
```

**Success (200)**

```json
{
  "ok": true,
  "message": "Interest sent."
}
```

**Errors:** 400 'Interest already sent.', 'Your profile must be approved…', opposite-gender / blocked / not accepting interests

---

## respond_interest

| | |
|---|---|
| Category | Interest Management |
| Endpoint | `/peoplelink/matrimoney/api.php?action=respond_interest` |
| Method | POST |
| Purpose | Accept or decline a received interest (+ notification to sender). Accepted = both see contact details. |
| Auth | Logged-in member (session cookie) |
| Headers | Accept: application/json; csrf in body |
| Query / extra params | - |
| Status | Updated (module-4) |
| Tables | matrimony_interests, user_notifications |
| Validation | decision = accepted \| rejected; only the receiver; only a pending interest (already answered → 409 ALREADY_ANSWERED) |
| Frontend | interests.php, profile.php |

**Request body**

```json
{
  "interest_id": 9,
  "decision": "accepted"
}
```

**Success (200)**

```json
{
  "ok": true,
  "message": "Interest accepted."
}
```

**Errors:** 400 'Invalid request.', 'Interest not found.'

---

## withdraw_interest

| | |
|---|---|
| Category | Interest Management |
| Endpoint | `/peoplelink/matrimoney/api.php?action=withdraw_interest` |
| Method | POST |
| Purpose | Withdraw a sent interest that is not answered yet. |
| Auth | Logged-in member (session cookie) |
| Headers | Accept: application/json; csrf in body |
| Query / extra params | - |
| Status | Existing |
| Tables | matrimony_interests |
| Validation | Only sender, only status sent |
| Frontend | interests.php, profile.php |

**Request body**

```json
{
  "interest_id": 9
}
```

**Success (200)**

```json
{
  "ok": true,
  "message": "Interest withdrawn."
}
```

**Errors:** 400 'Interest not found or already answered.'

---

## interests

| | |
|---|---|
| Category | Interest Management |
| Endpoint | `/peoplelink/matrimoney/api.php?action=interests` |
| Method | GET |
| Purpose | Received and sent interests with profile cards. |
| Auth | Logged-in member (session cookie) |
| Headers | Accept: application/json |
| Query / extra params | - |
| Status | Existing |
| Tables | matrimony_interests, matrimony_profiles |
| Validation | - |
| Frontend | interests.php |

**Success (200)**

```json
{
  "ok": true,
  "received": [
    {
      "id": 8,
      "name": "Asha T",
      "interest_id": 9,
      "interest_status": "sent",
      "message": "Hi",
      "interest_at": "2026-11-15 17:32:45"
    }
  ],
  "sent": []
}
```

**Errors:** 401 AUTH_REQUIRED

---

## toggle_save

| | |
|---|---|
| Category | Saved Profiles |
| Endpoint | `/peoplelink/matrimoney/api.php?action=toggle_save` |
| Method | POST |
| Purpose | Save / unsave a profile. |
| Auth | Logged-in member (session cookie) |
| Headers | Accept: application/json; csrf in body |
| Query / extra params | - |
| Status | Existing |
| Tables | matrimony_saved |
| Validation | Approved, active profile of own community |
| Frontend | search.php, profile.php, saved.php |

**Request body**

```json
{
  "profile_id": 9
}
```

**Success (200)**

```json
{
  "ok": true,
  "saved": true,
  "message": "Profile saved."
}
```

**Errors:** 404 PROFILE_NOT_FOUND

---

## saved

| | |
|---|---|
| Category | Saved Profiles |
| Endpoint | `/peoplelink/matrimoney/api.php?action=saved` |
| Method | GET |
| Purpose | My saved profiles. |
| Auth | Logged-in member (session cookie) |
| Headers | Accept: application/json |
| Query / extra params | - |
| Status | Existing |
| Tables | matrimony_saved, matrimony_profiles |
| Validation | - |
| Frontend | saved.php |

**Success (200)**

```json
{
  "ok": true,
  "profiles": [
    {
      "id": 9,
      "name": "Bharat T",
      "saved": true,
      "saved_at": "2026-11-15 17:40:00"
    }
  ]
}
```

**Errors:** 401 AUTH_REQUIRED

---

## contact_request

| | |
|---|---|
| Category | Communication / Contact |
| Endpoint | `/peoplelink/matrimoney/api.php?action=contact_request` |
| Method | POST |
| Purpose | Ask a member to share mobile + email. Uses 1 package credit (returned if declined/cancelled). |
| Auth | Logged-in member (session cookie) |
| Headers | Accept: application/json; csrf in body |
| Query / extra params | - |
| Status | New |
| Tables | matrimony_contact_requests, user_packages, packages, user_notifications |
| Validation | Own profile approved; active matrimony package with credits; target allows contact requests; opposite gender; not blocked; message ≤ 500 |
| Frontend | profile.php |

**Request body**

```json
{
  "profile_id": 8,
  "message": "Please share your number."
}
```

**Success (200)**

```json
{
  "ok": true,
  "message": "Contact request sent. You will be notified when it is answered.",
  "remaining": 0
}
```

**Errors:** 402 PACKAGE_REQUIRED, 402 PACKAGE_LIMIT_REACHED, 403 APPROVAL_PENDING, 403 PRIVACY_RESTRICTED, 409 ALREADY_REQUESTED, 409 ALREADY_APPROVED, 404 PROFILE_NOT_FOUND

---

## contact_respond

| | |
|---|---|
| Category | Communication / Contact |
| Endpoint | `/peoplelink/matrimoney/api.php?action=contact_respond` |
| Method | POST |
| Purpose | Approve (share contact) or decline a received contact request. |
| Auth | Logged-in member (session cookie) |
| Headers | Accept: application/json; csrf in body |
| Query / extra params | - |
| Status | New |
| Tables | matrimony_contact_requests, user_packages, user_notifications |
| Validation | decision = approved | declined; only the target member; pending only |
| Frontend | contacts.php |

**Request body**

```json
{
  "request_id": 1,
  "decision": "approved"
}
```

**Success (200)**

```json
{
  "ok": true,
  "message": "Contact details shared."
}
```

**Errors:** 404 NOT_FOUND, 400 VALIDATION_ERROR

---

## contact_cancel

| | |
|---|---|
| Category | Communication / Contact |
| Endpoint | `/peoplelink/matrimoney/api.php?action=contact_cancel` |
| Method | POST |
| Purpose | Cancel my pending contact request (credit returned). |
| Auth | Logged-in member (session cookie) |
| Headers | Accept: application/json; csrf in body |
| Query / extra params | - |
| Status | New |
| Tables | matrimony_contact_requests, user_packages |
| Validation | Only requester, pending only |
| Frontend | profile.php, contacts.php |

**Request body**

```json
{
  "request_id": 1
}
```

**Success (200)**

```json
{
  "ok": true,
  "message": "Request cancelled and credit returned."
}
```

**Errors:** 404 NOT_FOUND

---

## contact_requests

| | |
|---|---|
| Category | Communication / Contact |
| Endpoint | `/peoplelink/matrimoney/api.php?action=contact_requests` |
| Method | GET |
| Purpose | Received and sent contact requests. Sent + approved rows include phone/email. |
| Auth | Logged-in member (session cookie) |
| Headers | Accept: application/json |
| Query / extra params | - |
| Status | New |
| Tables | matrimony_contact_requests, matrimony_profiles |
| Validation | - |
| Frontend | contacts.php |

**Success (200)**

```json
{
  "ok": true,
  "received": [
    {
      "id": 9,
      "name": "Bharat T",
      "request_id": 1,
      "request_status": "pending",
      "message": "Please share"
    }
  ],
  "sent": [
    {
      "id": 8,
      "name": "Asha T",
      "request_id": 2,
      "request_status": "approved",
      "phone": "9876500001",
      "email": "asha@example.com"
    }
  ]
}
```

**Errors:** 401 AUTH_REQUIRED

---

## matrimony_privacy

| | |
|---|---|
| Category | Privacy |
| Endpoint | `/peoplelink/matrimoney/api.php?action=matrimony_privacy` |
| Method | GET |
| Purpose | Read matrimony privacy settings. |
| Auth | Logged-in member (session cookie) |
| Headers | Accept: application/json |
| Query / extra params | - |
| Status | Existing |
| Tables | matrimony_profiles.details |
| Validation | - |
| Frontend | privacy.php (server-rendered) |

**Success (200)**

```json
{
  "ok": true,
  "privacy": {
    "profileVisibility": "visible",
    "photoPrivacy": "eligible",
    "receiveInterests": true,
    "allowContactRequests": true,
    "profileRecommendations": true,
    "notifyInterests": true,
    "notifyContacts": true,
    "notifyPackages": true,
    "notifyProfile": true
  },
  "is_active": true
}
```

**Errors:** 400 'Create your profile first.'

---

## matrimony_privacy_save

| | |
|---|---|
| Category | Privacy |
| Endpoint | `/peoplelink/matrimoney/api.php?action=matrimony_privacy_save` |
| Method | POST |
| Purpose | Save privacy settings (visibility, photo privacy, interest/contact switches, push switches). |
| Auth | Logged-in member (session cookie) |
| Headers | Accept: application/json; csrf in body |
| Query / extra params | - |
| Status | Existing |
| Tables | matrimony_profiles |
| Validation | profile_visibility: visible|hidden|deactivated; photo_privacy: eligible|interest|contact|private; switches: 1 or missing |
| Frontend | privacy.php |

**Request body**

```json
{
  "profile_visibility": "visible",
  "photo_privacy": "interest",
  "receive_interests": 1,
  "allow_contact_requests": 1,
  "profile_recommendations": 1,
  "notify_interests": 1,
  "notify_contacts": 1,
  "notify_packages": 1,
  "notify_profile": 1
}
```

**Success (200)**

```json
{
  "ok": true,
  "message": "Privacy settings saved.",
  "privacy": {
    "profileVisibility": "visible",
    "photoPrivacy": "interest"
  }
}
```

**Errors:** 400 'Create your profile first.'

---

## block_profile

| | |
|---|---|
| Category | Privacy |
| Endpoint | `/peoplelink/matrimoney/api.php?action=block_profile` |
| Method | POST |
| Purpose | Block (1) or unblock (0) a profile. Blocking removes it from my saved list, search, and declines its pending interest. |
| Auth | Logged-in member (session cookie) |
| Headers | Accept: application/json; csrf in body |
| Query / extra params | - |
| Status | Existing |
| Tables | matrimony_blocks, matrimony_saved, matrimony_interests |
| Validation | Cannot block own profile |
| Frontend | profile.php, privacy.php |

**Request body**

```json
{
  "profile_id": 6,
  "block": 1
}
```

**Success (200)**

```json
{
  "ok": true,
  "message": "Profile blocked. …",
  "blocked": true
}
```

**Errors:** 400 'Profile not found.'

---

## blocked_profiles

| | |
|---|---|
| Category | Privacy |
| Endpoint | `/peoplelink/matrimoney/api.php?action=blocked_profiles` |
| Method | GET |
| Purpose | My blocked profiles. |
| Auth | Logged-in member (session cookie) |
| Headers | Accept: application/json |
| Query / extra params | - |
| Status | Existing |
| Tables | matrimony_blocks |
| Validation | - |
| Frontend | privacy.php |

**Success (200)**

```json
{
  "ok": true,
  "profiles": [
    {
      "id": 6,
      "code": "PL-MAT-2006",
      "name": "Vijay Kumar",
      "blocked_at": "2026-11-15 17:45:00"
    }
  ]
}
```

**Errors:** 401 AUTH_REQUIRED

---

## report_profile

| | |
|---|---|
| Category | Reports |
| Endpoint | `/peoplelink/matrimoney/api.php?action=report_profile` |
| Method | POST |
| Purpose | Report a profile to admins; optional block at the same time. |
| Auth | Logged-in member (session cookie) |
| Headers | Accept: application/json; csrf in body |
| Query / extra params | - |
| Status | Updated (module-4) |
| Tables | matrimony_reports (reporter_user_id), matrimony_blocks |
| Validation | reason required; one open report per reporter per profile; reason+details ≤ 255 |
| Frontend | profile.php |

**Request body**

```json
{
  "profile_id": 6,
  "reason": "Fake profile",
  "details": "Photo is from the internet",
  "also_block": 1
}
```

**Success (200)**

```json
{
  "ok": true,
  "message": "Report submitted. Our team will review it."
}
```

**Errors:** 400 VALIDATION_ERROR, 400 CANNOT_REPORT_OWN_CONTENT, 409 ALREADY_REPORTED, 404 PROFILE_NOT_FOUND

---

## packages

| | |
|---|---|
| Category | Membership & Payment |
| Endpoint | `/peoplelink/matrimoney/api.php?action=packages` |
| Method | GET |
| Purpose | Matrimony packages from the common packages table (module_key = matrimony). |
| Auth | Not required |
| Headers | Accept: application/json |
| Query / extra params | - |
| Status | Updated (module-4) |
| Tables | packages |
| Validation | Only active packages of the member's community or global |
| Frontend | packages.php |

**Success (200)**

```json
{
  "ok": true,
  "packages": [
    {
      "id": 11,
      "name": "Silver",
      "price": 499,
      "validity_days": 90,
      "contact_views": 30,
      "description": "…",
      "features": [
        "…"
      ],
      "is_featured": false
    }
  ]
}
```

**Errors:** -

---

## package_details

| | |
|---|---|
| Category | Membership & Payment |
| Endpoint | `/peoplelink/matrimoney/api.php?action=package_details` |
| Method | GET |
| Purpose | One matrimony package. |
| Auth | Not required |
| Headers | Accept: application/json |
| Query / extra params | id |
| Status | New |
| Tables | packages |
| Validation | - |
| Frontend | Flutter package details |

**Success (200)**

```json
{
  "ok": true,
  "package": {
    "id": 11,
    "name": "Silver",
    "price": 499,
    "validity_days": 90,
    "contact_views": 30
  }
}
```

**Errors:** 404 PACKAGE_NOT_FOUND

---

## order_package

| | |
|---|---|
| Category | Membership & Payment |
| Endpoint | `/peoplelink/matrimoney/api.php?action=order_package` |
| Method | POST |
| Purpose | Create a Razorpay order for a package. The price is read on the server. Open Razorpay Checkout with the response, then call payment_verify. |
| Auth | Logged-in member (session cookie) |
| Headers | Accept: application/json; csrf in body |
| Query / extra params | - |
| Status | Updated (module-4) |
| Tables | packages, transactions |
| Validation | package must be active and belong to the member's community or be global |
| Frontend | packages.php |

**Request body**

```json
{
  "package_id": 12
}
```

**Success (200)**

```json
{
  "ok": true,
  "message": "Order created.",
  "transaction_id": 7,
  "txn_code": "PL-TXN-100007",
  "key_id": "rzp_live_…",
  "order_id": "order_Nx…",
  "amount": 99900,
  "currency": "INR",
  "name": "PeopleLink",
  "description": "Gold",
  "prefill": {
    "name": "Asha T",
    "email": "asha@example.com",
    "contact": "9876500001"
  }
}
```

**Errors:** 400 PROFILE_REQUIRED, 404 PACKAGE_NOT_FOUND, 502 PAYMENT_FAILED (e.g. Razorpay keys not set)

---

## payment_verify

| | |
|---|---|
| Category | Membership & Payment |
| Endpoint | `/peoplelink/matrimoney/api.php?action=payment_verify` |
| Method | POST |
| Purpose | Verify Razorpay signature + capture, mark transaction paid and activate the package (idempotent; webhook does the same). |
| Auth | Logged-in member (session cookie) |
| Headers | Accept: application/json; csrf in body |
| Query / extra params | - |
| Status | Existing (common) |
| Tables | transactions, user_packages, user_notifications, audit_log |
| Validation | HMAC-SHA256 signature check; amount must match |
| Frontend | packages.php (Razorpay handler) |

**Request body**

```json
{
  "razorpay_order_id": "order_Nx…",
  "razorpay_payment_id": "pay_Nx…",
  "razorpay_signature": "…"
}
```

**Success (200)**

```json
{
  "ok": true,
  "message": "Payment successful.",
  "status": "paid",
  "transaction_id": 7,
  "txn_code": "PL-TXN-100007"
}
```

**Errors:** 400/402/502 PAYMENT_FAILED, 404 NOT_FOUND

---

## my_packages

| | |
|---|---|
| Category | Membership & Payment |
| Endpoint | `/peoplelink/matrimoney/api.php?action=my_packages` |
| Method | GET |
| Purpose | Active matrimony package(s), credits left, and payment history (incl. old manual orders). |
| Auth | Logged-in member (session cookie) |
| Headers | Accept: application/json |
| Query / extra params | - |
| Status | Updated (module-4) |
| Tables | user_packages, packages, transactions, matrimony_payments |
| Validation | - |
| Frontend | packages.php, my-profile.php |

**Success (200)**

```json
{
  "ok": true,
  "active": {
    "user_package_id": 4,
    "name": "Silver",
    "expires_at": "2027-02-13 17:40:00",
    "days_left": 90,
    "contact_views": 30,
    "used": 1,
    "remaining": 29
  },
  "entitlement": {
    "active": true,
    "remaining": 29
  },
  "orders": [
    {
      "txn_code": "PL-TXN-100007",
      "package": "Gold",
      "amount": 999,
      "status": "paid"
    }
  ]
}
```

**Errors:** 401 AUTH_REQUIRED

---

## payment_status / payment_history / payment_receipt

| | |
|---|---|
| Category | Membership & Payment |
| Endpoint | `/peoplelink/matrimoney/api.php?action=payment_status` |
| Method | GET |
| Purpose | Common payment endpoints (all modules). Use module=matrimony where supported. |
| Auth | Logged-in member (session cookie) |
| Headers | Accept: application/json |
| Query / extra params | id / order_id |
| Status | Existing (common) |
| Tables | transactions |
| Validation | - |
| Frontend | Flutter payments screens |

**Success (200)**

```json
{
  "ok": true,
  "transaction": {
    "id": 7,
    "status": "paid"
  }
}
```

**Errors:** 404 NOT_FOUND

---

## matrimony_notifications

| | |
|---|---|
| Category | Notifications |
| Endpoint | `/peoplelink/matrimoney/api.php?action=matrimony_notifications` |
| Method | GET |
| Purpose | Matrimony notifications (interests, contact requests, approvals, package) + older admin notices. |
| Auth | Logged-in member (session cookie) |
| Headers | Accept: application/json |
| Query / extra params | page, per |
| Status | New |
| Tables | user_notifications (type=matrimony), matrimony_notifications |
| Validation | ids starting with 'u' can be marked read; 'm' (old admin notices) are always read |
| Frontend | notifications.php, header badge |

**Success (200)**

```json
{
  "ok": true,
  "notifications": [
    {
      "id": "u34",
      "title": "Interest accepted",
      "message": "Bharat T accepted your interest…",
      "event": "matrimony_interest_accepted",
      "profile_id": 9,
      "is_read": false,
      "created_at": "2026-11-15 17:33:00"
    }
  ],
  "total": 3,
  "page": 1,
  "per": 15,
  "total_pages": 1,
  "unread": 1
}
```

**Errors:** 401 AUTH_REQUIRED

---

## matrimony_notification_read

| | |
|---|---|
| Category | Notifications |
| Endpoint | `/peoplelink/matrimoney/api.php?action=matrimony_notification_read` |
| Method | POST |
| Purpose | Mark one (id) or all (all=1) matrimony notifications as read. |
| Auth | Logged-in member (session cookie) |
| Headers | Accept: application/json; csrf in body |
| Query / extra params | - |
| Status | New |
| Tables | user_notifications |
| Validation | Only own notifications |
| Frontend | notifications.php |

**Request body**

```json
{
  "id": "u34"
}
```

**Success (200)**

```json
{
  "ok": true,
  "message": "Marked as read.",
  "unread": 0
}
```

**Errors:** -

---

## account_* (profile, settings, change_password, devices, deactivate, delete_request)

| | |
|---|---|
| Category | Account |
| Endpoint | `/peoplelink/matrimoney/api.php?action=account_*` |
| Method | GET/POST |
| Purpose | Shared account management (Module 13). Not duplicated for matrimony. |
| Auth | Logged-in member (session cookie) |
| Headers | Accept: application/json |
| Query / extra params | see account_api.php |
| Status | Existing (common) |
| Tables | users, user_sessions |
| Validation | Password ≥ 6 |
| Frontend | first/profile/* pages |

**Success (200)**

```json
{
  "ok": true
}
```

**Errors:** 401 INVALID_CREDENTIALS etc.

---

## support_request

| | |
|---|---|
| Category | Support |
| Endpoint | `/peoplelink/matrimoney/api.php?action=support_request` |
| Method | POST |
| Purpose | Create a matrimony help ticket. |
| Auth | Logged-in member (session cookie) |
| Headers | Accept: application/json; csrf in body |
| Query / extra params | - |
| Status | Existing |
| Tables | matrimony_support |
| Validation | title + description required (browser also checks category, ≥ 15 chars) |
| Frontend | support.php |

**Request body**

```json
{
  "support_category": "Package / payment",
  "request_title": "Payment deducted",
  "description": "Paid but package not active",
  "contact_name": "Asha T",
  "phone": "9876500001"
}
```

**Success (200)**

```json
{
  "ok": true,
  "message": "Support request submitted. Your ticket number is PLM-SUP-10001.",
  "request_id": 1,
  "ticket": "PLM-SUP-10001"
}
```

**Errors:** 400 'Title and description are required.'

---

## my_support_requests

| | |
|---|---|
| Category | Support |
| Endpoint | `/peoplelink/matrimoney/api.php?action=my_support_requests` |
| Method | GET |
| Purpose | My help tickets. |
| Auth | Logged-in member (session cookie) |
| Headers | Accept: application/json |
| Query / extra params | - |
| Status | Existing |
| Tables | matrimony_support |
| Validation | - |
| Frontend | support.php |

**Success (200)**

```json
{
  "ok": true,
  "requests": [
    {
      "id": 1,
      "ticket": "PLM-SUP-10001",
      "title": "Payment deducted",
      "category": "Package / payment",
      "status": "open"
    }
  ]
}
```

**Errors:** -

---

## Dashboard pages (server-rendered)

| | |
|---|---|
| Category | Admin |
| Endpoint | `/peoplelink/matrimoney/api.php?action=Dashboard` |
| Method | GET/POST form |
| Purpose | Admin uses dashboard pages, not JSON: matrimony/profiles.php (approve/reject/activate), photo-approval.php, interests.php, reports-profiles.php, notifications.php, support.php; Packages & Transactions under admin/manage.php?e=package and admin/transactions.php. |
| Auth | Admin session |
| Headers | Accept: application/json |
| Query / extra params | - |
| Status | Existing |
| Tables | matrimony_*, packages, transactions |
| Validation | CSRF on every form; community-scoped |
| Frontend | matrimoney/ dashboard |

**Errors:** redirect + flash message
