# Memory

This folder is the project memory for ATP 3.0 Laravel frontend work.

Use it as the repo-level source of truth when the user explicitly asks to:
- remember a style
- remember an implementation rule
- remember a code pattern
- remember a UI behavior or decision

## How It Works

- `source-of-truth.md` is the canonical current guidance.
- `decision-log.md` is the dated historical record of what was agreed and why.

When a new memory is requested:
1. Update `source-of-truth.md` if the rule should guide future implementation.
2. Append a dated note to `decision-log.md`.

## Scope

This memory is for durable project conventions, not temporary TODOs.

Examples:
- approved UI patterns
- preferred interaction styles
- reusable component behavior
- implementation rules that should be preserved across pages/modules

Non-examples:
- one-off debugging notes
- transient errors that are already fixed
- generic framework defaults that do not reflect a project decision
