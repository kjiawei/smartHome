/*
 * Copyright (C) 2007 The Android Open Source Project
 */

package com.mysmarthome.mynode.rssreader;

public class RssItem  {
    private CharSequence mTitle;
    private CharSequence mLink;
    private CharSequence mDescription;
    
    public RssItem() {
        mTitle = "";
        mLink = "";
        mDescription = "";
    }
    
    public RssItem(CharSequence title, CharSequence link, CharSequence description) {
        mTitle = title;
        mLink = link;
        mDescription = description;
    }

    public CharSequence getDescription() {
        return mDescription;
    }

    public void setDescription(CharSequence description) {
        mDescription = description;
    }

    public CharSequence getLink() {
        return mLink;
    }

    public void setLink(CharSequence link) {
        mLink = link;
    }

    public CharSequence getTitle() {
        return mTitle;
    }
    public void setTitle(CharSequence title) {
        mTitle = title;
    }
}

