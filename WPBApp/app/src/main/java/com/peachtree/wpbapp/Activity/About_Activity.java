package com.peachtree.wpbapp.activity;

import android.content.Intent;
import android.os.Bundle;
import android.support.design.widget.NavigationView;
import android.support.v4.view.GravityCompat;
import android.support.v4.widget.DrawerLayout;
import android.support.v7.app.ActionBarDrawerToggle;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.view.MenuItem;
import android.widget.ExpandableListView;

import com.peachtree.wpbapp.R;
import com.peachtree.wpbapp.core.Util;
import com.peachtree.wpbapp.layout_Handlers.Accordion_Handler;

import org.xmlpull.v1.XmlPullParserException;

import java.io.IOException;

public class About_Activity extends AppCompatActivity
        implements NavigationView.OnNavigationItemSelectedListener {
	private Accordion_Handler accordion_handler;
	private final int ABOUT_SRC_FILE = R.raw.about_items;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.about_activity);
        Toolbar toolbar = (Toolbar) findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);

        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        ActionBarDrawerToggle toggle = new ActionBarDrawerToggle(
                this, drawer, toolbar, R.string.navigation_drawer_open, R.string.navigation_drawer_close);
        drawer.setDrawerListener(toggle);
        toggle.syncState();

        NavigationView navigationView = (NavigationView) findViewById(R.id.nav_view);
        navigationView.setNavigationItemSelectedListener(this);

		accordion_handler = new Accordion_Handler(this, ABOUT_SRC_FILE);

		((ExpandableListView)findViewById(R.id.EXP_about)).setAdapter(accordion_handler);
    }

    @Override
    public void onBackPressed() {
        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        if (drawer.isDrawerOpen(GravityCompat.START)) {
            drawer.closeDrawer(GravityCompat.START);
        } else {
            super.onBackPressed();
        }
    }

    @SuppressWarnings("StatementWithEmptyBody")
    @Override
    public boolean onNavigationItemSelected(MenuItem item) {
        // Handle navigation view item clicks here.
        Intent nav = Util.getNavIntent(item.getItemId(), this);

        if(nav != null){
            startActivity(nav);
        }else if (item.getItemId() == R.id.nav_logout){

        }
        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        drawer.closeDrawer(GravityCompat.START);

        return true;
    }
}
