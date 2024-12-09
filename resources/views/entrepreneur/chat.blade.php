@extends('entrepreneur.layout')

@section('title', 'Chat - Auxiliare')

@section('content')
<div class="chat-wrapper">
    <div class="contacts-sidebar">
        <div class="contacts-header">
            <h3>Messages</h3>
            <input type="text" placeholder="Search contacts..." class="contact-search">
        </div>
        <div class="contacts-list">
            <!-- Contact list items will be populated dynamically -->
        </div>
    </div>
    
    <div class="chat-main">
        <div class="chat-header">
            <div class="chat-contact-info">
                <img src="{{ asset('assets/default-avatar.png') }}" alt="Contact" class="avatar">
                <div class="contact-details">
                    <h4>Select a contact</h4>
                    <span class="status">Start a conversation</span>
                </div>
            </div>
        </div>
        
        <div class="messages-container">
            <!-- Messages will be populated here -->
        </div>
        
        <div class="chat-input-area">
            <form id="message-form" class="message-form">
                @csrf
                <input type="text" placeholder="Type your message..." id="message-input">
                <button type="submit">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </form>
        </div>
    </div>
</div>
@endsection