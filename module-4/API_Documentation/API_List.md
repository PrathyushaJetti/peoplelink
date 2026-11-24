# Matrimony (Module 4) – API List

All endpoints go through the shared router **`/peoplelink/matrimoney/api.php?action=<name>`** (same session, CSRF and community lock as the rest of PeopleLink).

- **Web:** session cookie + `csrf` form field on every POST.
- **Flutter / Postman:** same; send JSON body (`Content-Type: application/json`) or form-data; get `csrf` from `session`.
- Response: `{"ok":true, …}` or `{"ok":false, "code":"…", "error":"…"}` (kept as-is so the existing Flutter app keeps working).
- Status: **Existing** = already in backend, reused · **Updated (module-4)** = wrapped with new rules · **New** = added in module-4.

_Last updated: 15 Nov 2026 – all statuses below are implemented and tested locally._

## Authentication

| API | Method | Endpoint | Purpose | Auth | Status |
|---|---|---|---|---|---|
| register | POST | `?action=register` | Create a member account and log in (same session as website). | No | Existing |
| login | POST | `?action=login` | Log in with email + password. Max 3 active devices. | No | Existing |
| logout | POST | `?action=logout` | End the current session. | No | Existing |
| session | GET | `?action=session` | Current user, community, matrimony profile and CSRF token. | No | Existing |

## Profile

| API | Method | Endpoint | Purpose | Auth | Status |
|---|---|---|---|---|---|
| create_profile | POST | `?action=create_profile` | Create the member's matrimony profile (status pending until admin approval). Optional photos[] files. | Yes | Updated (module-4) |
| update_profile | POST | `?action=update_profile` | Edit own profile. An approved profile goes back to pending (re-approval). Gender cannot be changed. | Yes | Updated (module-4) |
| me | GET | `?action=me` | Own profile with completion %, dashboard counts and package status. | Yes | Updated (module-4) |
| profile | GET | `?action=profile` | View one profile. Members see only their community. Adds match %, contact-request state; logs a profile visit. | Optional | Updated (module-4) |
| profile_set_active | POST | `?action=profile_set_active` | Hide (0) or show (1) own profile in search. | Yes | Existing |
| matrimony_dashboard | GET | `?action=matrimony_dashboard` | Counts, completion % and package status for the dashboard (lighter than `me`). | Yes | New |

## Photos

| API | Method | Endpoint | Purpose | Auth | Status |
|---|---|---|---|---|---|
| upload_photos | POST | `?action=upload_photos` | Upload photos (multipart, field photos[]). New photos are pending admin approval; first photo becomes main. | Yes | Existing |
| delete_photo | POST | `?action=delete_photo` | Delete own photo (files removed). | Yes | Existing |
| set_primary_photo | POST | `?action=set_primary_photo` | Make a photo the main photo. | Yes | Existing |

## Partner Preferences

| API | Method | Endpoint | Purpose | Auth | Status |
|---|---|---|---|---|---|
| save_preferences | POST | `?action=save_preferences` | Add / update partner preferences (used for match %). | Yes | Existing |
| (read) me / profile | GET | `?action=(read)` | Preferences are returned inside `me` and `profile` as `preferences`. | Yes | Existing |

## Search

| API | Method | Endpoint | Purpose | Auth | Status |
|---|---|---|---|---|---|
| search | GET | `?action=search` | Search approved profiles of the community. Logged-in members see only the opposite gender, never blocked profiles. Adds match %. | Optional | Updated (module-4) |
| matrimony_filters | GET | `?action=matrimony_filters` | Real dropdown values from approved profiles of the community. | No | New |
| matrimony_visitors | GET | `?action=matrimony_visitors` | Approved members who viewed my profile (one row per member). | Yes | New |

## Interest Management

| API | Method | Endpoint | Purpose | Auth | Status |
|---|---|---|---|---|---|
| send_interest | POST | `?action=send_interest` | Send interest to a profile (+ in-app/push notification to receiver). | Yes | Updated (module-4) |
| respond_interest | POST | `?action=respond_interest` | Accept or decline a received interest (+ notification to sender). Accepted = both see contact details. | Yes | Updated (module-4) |
| withdraw_interest | POST | `?action=withdraw_interest` | Withdraw a sent interest that is not answered yet. | Yes | Existing |
| interests | GET | `?action=interests` | Received and sent interests with profile cards. | Yes | Existing |

## Saved Profiles

| API | Method | Endpoint | Purpose | Auth | Status |
|---|---|---|---|---|---|
| toggle_save | POST | `?action=toggle_save` | Save / unsave a profile. | Yes | Existing |
| saved | GET | `?action=saved` | My saved profiles. | Yes | Existing |

## Communication / Contact

| API | Method | Endpoint | Purpose | Auth | Status |
|---|---|---|---|---|---|
| contact_request | POST | `?action=contact_request` | Ask a member to share mobile + email. Uses 1 package credit (returned if declined/cancelled). | Yes | New |
| contact_respond | POST | `?action=contact_respond` | Approve (share contact) or decline a received contact request. | Yes | New |
| contact_cancel | POST | `?action=contact_cancel` | Cancel my pending contact request (credit returned). | Yes | New |
| contact_requests | GET | `?action=contact_requests` | Received and sent contact requests. Sent + approved rows include phone/email. | Yes | New |

## Privacy

| API | Method | Endpoint | Purpose | Auth | Status |
|---|---|---|---|---|---|
| matrimony_privacy | GET | `?action=matrimony_privacy` | Read matrimony privacy settings. | Yes | Existing |
| matrimony_privacy_save | POST | `?action=matrimony_privacy_save` | Save privacy settings (visibility, photo privacy, interest/contact switches, push switches). | Yes | Existing |
| block_profile | POST | `?action=block_profile` | Block (1) or unblock (0) a profile. Blocking removes it from my saved list, search, and declines its pending interest. | Yes | Existing |
| blocked_profiles | GET | `?action=blocked_profiles` | My blocked profiles. | Yes | Existing |

## Reports

| API | Method | Endpoint | Purpose | Auth | Status |
|---|---|---|---|---|---|
| report_profile | POST | `?action=report_profile` | Report a profile to admins; optional block at the same time. | Yes | Updated (module-4) |

## Membership & Payment

| API | Method | Endpoint | Purpose | Auth | Status |
|---|---|---|---|---|---|
| packages | GET | `?action=packages` | Matrimony packages from the common packages table (module_key = matrimony). | No | Updated (module-4) |
| package_details | GET | `?action=package_details` | One matrimony package. | No | New |
| order_package | POST | `?action=order_package` | Create a Razorpay order for a package. The price is read on the server. Open Razorpay Checkout with the response, then call payment_verify. | Yes | Updated (module-4) |
| payment_verify | POST | `?action=payment_verify` | Verify Razorpay signature + capture, mark transaction paid and activate the package (idempotent; webhook does the same). | Yes | Existing (common) |
| my_packages | GET | `?action=my_packages` | Active matrimony package(s), credits left, and payment history (incl. old manual orders). | Yes | Updated (module-4) |
| payment_status / payment_history / payment_receipt | GET | `?action=payment_status` | Common payment endpoints (all modules). Use module=matrimony where supported. | Yes | Existing (common) |

## Notifications

| API | Method | Endpoint | Purpose | Auth | Status |
|---|---|---|---|---|---|
| matrimony_notifications | GET | `?action=matrimony_notifications` | Matrimony notifications (interests, contact requests, approvals, package) + older admin notices. | Yes | New |
| matrimony_notification_read | POST | `?action=matrimony_notification_read` | Mark one (id) or all (all=1) matrimony notifications as read. | Yes | New |

## Account

| API | Method | Endpoint | Purpose | Auth | Status |
|---|---|---|---|---|---|
| account_* (profile, settings, change_password, devices, deactivate, delete_request) | GET/POST | `?action=account_*` | Shared account management (Module 13). Not duplicated for matrimony. | Yes | Existing (common) |

## Support

| API | Method | Endpoint | Purpose | Auth | Status |
|---|---|---|---|---|---|
| support_request | POST | `?action=support_request` | Create a matrimony help ticket. | Yes | Existing |
| my_support_requests | GET | `?action=my_support_requests` | My help tickets. | Yes | Existing |

## Admin

| API | Method | Endpoint | Purpose | Auth | Status |
|---|---|---|---|---|---|
| Dashboard pages (server-rendered) | GET/POST form | `?action=Dashboard` | Admin uses dashboard pages, not JSON: matrimony/profiles.php (approve/reject/activate), photo-approval.php, interests.php, reports-profiles.php, notifications.php, support.php; Packages & Transactions under admin/manage.php?e=package and admin/transactions.php. | Admin session | Existing |

## Not included (outside approved Phase 1 scope)

- Real-time chat, horoscope matching, video calls, AI matchmaking (Phase 2 per spec).
- OTP / forgot password: belong to common Auth (Module 1/13), not to Matrimony.
