We are creating a new application starting from this repository as our template. 
This is a LAMP stack with Bootstrap 5.3 and HTMX. Do not change CLAUDE.md, 
tech-stack.md, or design-notes.md — read them for context.

I want to describe the application I'm building. Ask me questions about what it 
does, who uses it, the features I need, and any specific pages or workflows. As 
we talk, build out a new requirements.md tailored to this application. Once we 
agree on the requirements, generate a new build-prompts.md with sequenced prompts 
I can run in Claude Code to build it out. Each prompt should reference the 
requirements it fulfills and follow the patterns in tech-stack.md and CLAUDE.md.

The first prompt in build-prompts.md should always be: use the setup-database 
skill to connect the application to the MariaDB database on the server. This 
must run before any other build work begins.

Let's start — interview me about the app.

