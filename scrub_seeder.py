# Scrub PII fields (name, ic, email, phone, bank info) dalam seeder, replace dengan dummy unik per record.

import re
import sys

SENSITIVE_STRING_FIELDS = [
    "ic",
    "name",
    "email",
    "epf_number",
    "phone_number",
    "secondary_phone_number",
    "bank_name",
    "bank_account_number",
    "ic_address",
    "current_address",
]


def make_value(field: str, n: int) -> str:
    if field == "ic":
        return f"{n:012d}"
    if field == "name":
        return f"Staff Member {n}"
    if field == "email":
        return f"staff{n}@example.com"
    if field == "epf_number":
        return f"EPF{n:06d}"
    if field in ("phone_number", "secondary_phone_number"):
        return f"010{n:07d}"
    if field == "bank_name":
        return "Demo Bank"
    if field == "bank_account_number":
        return f"{n:010d}"
    if field in ("ic_address", "current_address"):
        return f"No. {n}, Jalan Demo, 43000 Kajang, Selangor"
    return "N/A"


def scrub(content: str) -> str:
    counters = {field: 0 for field in SENSITIVE_STRING_FIELDS}

    for field in SENSITIVE_STRING_FIELDS:
        pattern = re.compile(
            r"(['\"])" + re.escape(field) + r"\1(\s*=>\s*)(['\"])(.*?)\3",
            re.DOTALL,
        )

        def replacer(match, field=field):
            counters[field] += 1
            quote_key = match.group(1)
            arrow = match.group(2)
            quote_val = match.group(3)
            new_val = make_value(field, counters[field])
            return f"{quote_key}{field}{quote_key}{arrow}{quote_val}{new_val}{quote_val}"

        content = pattern.sub(replacer, content)

    # Password: Hash::make('...') -> same dummy hash source for everyone
    content = re.sub(
        r"Hash::make\((['\"]).*?\1\)",
        "Hash::make('password123')",
        content,
    )

    # Comment lines like "// 3) REAL NAME (Admin - NOTE)" -> scrub the name part,
    # keep the numbering and any trailing (role - note) annotation.
    def comment_replacer(match):
        n = match.group("num")
        tail = match.group("tail") or ""
        return f"// {n}) Staff Member {n} {tail}".rstrip()

    content = re.sub(
        r"//\s*(?P<num>\d+)\)\s*[^\n(]*(?P<tail>\(.*)?$",
        comment_replacer,
        content,
        flags=re.MULTILINE,
    )

    return content, counters


def main():
    if len(sys.argv) != 2:
        print("Usage: python scrub_seeder.py path/to/UserSeeder.php")
        sys.exit(1)

    path = sys.argv[1]

    with open(path, "r", encoding="utf-8") as f:
        original = f.read()

    scrubbed, counters = scrub(original)

    with open(path, "w", encoding="utf-8") as f:
        f.write(scrubbed)

    print(f"Done. Fields scrubbed in: {path}")
    for field, count in counters.items():
        print(f"  {field}: {count} replaced")


if __name__ == "__main__":
    main()
