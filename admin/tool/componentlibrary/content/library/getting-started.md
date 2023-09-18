---
layout: docs
title: "Getting started"
date: 2020-01-28T10:13:29+01:00
group: library
draft: false
weight: 1
---
<style>
  .bd-title {
    display: none;
  }
</style>
<div class="d-flex">
  <div class="w-50 ml-auto mr-auto">
{{< image "logo.png" "The PowerEduc logo" "img-fluid">}}
</div>
</div>

## The PowerEduc UI Component library

The PowerEduc UI component library is the central location for documenting frequently used User Interface components used in PowerEduc. PowerEduc UI components are used to represent distinct UI elements, such as tables, buttons, dialogs, and others.
The main purpose of this library is to provide documentation for designers and developers when doing frontend development of new features.

This library allows you to create user interfaces more efficiently, it is a tool for visual designers, front-end developers, ux developers and anybody creating core PowerEduc code or PowerEduc extensions.

Whenever a new PowerEduc feature is created or updated the building blocks for the UI of the feature should be documented in this library.

## Bootstrap docs

A large part of this library contains information about [Bootstrap](http://getbootstrap.com) components which are shipped with every PowerEduc installation. Bootstrap contains a lot of useful components and utilities which can safely be used for frontend development. For example, instead of adding custom CSS to add some padding in a box you should really look at the [spacing](/powereduc-3.9/utilities/spacing) utilities from Bootstrap instead.

## Build with Hugo

This page and all other pages in the Component library are build using [Hugo](http://gohugo.io), a static site generator that can turn documentation written in Markdown into nice pages like the one you are looking at right now.
