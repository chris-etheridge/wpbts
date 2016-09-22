package com.peachtree.wpbapp.activity;

import android.content.Intent;
import android.graphics.drawable.Drawable;
import android.graphics.drawable.DrawableContainer;
import android.os.Bundle;
import android.support.design.widget.NavigationView;
import android.support.v4.view.GravityCompat;
import android.support.v4.widget.DrawerLayout;
import android.support.v7.app.ActionBarDrawerToggle;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.util.DisplayMetrics;
import android.view.MenuItem;
import android.view.View;
import android.widget.ExpandableListView;
import android.widget.ImageView;

import com.peachtree.wpbapp.R;
import com.peachtree.wpbapp.core.Util;
import com.peachtree.wpbapp.layout_Handlers.Accordion_Handler;

public class About_Activity extends AppCompatActivity
		implements NavigationView.OnNavigationItemSelectedListener
{
	private Accordion_Handler accordion_handler;
	private final int ABOUT_SRC_FILE = R.raw.about_items;
	private static int group_pos = -1;
	private ExpandableListView expandableListView;

	@Override
	protected void onCreate(Bundle savedInstanceState)
	{
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

		(expandableListView = ((ExpandableListView) findViewById(R.id.EXP_about))).setAdapter(accordion_handler);
		expandableListView.setOnGroupExpandListener(new ExpandableListView.OnGroupExpandListener()
		{
			public void onGroupExpand(int i)
			{
					if(expandableListView.isGroupExpanded(i))
					{
						expandableListView.findViewWithTag("Group_" + i).findViewById(R.id.ARROW_DOWN).setVisibility(View.GONE);
						expandableListView.findViewWithTag("Group_" + i).findViewById(R.id.ARROW_UP).setVisibility(View.VISIBLE);
					}
					if (group_pos >= 0 && i!= group_pos)
					{
						expandableListView.collapseGroup(group_pos);
					}

				group_pos = i;
			}
		});
		expandableListView.setOnGroupCollapseListener(new ExpandableListView.OnGroupCollapseListener()
		{
			@Override
			public void onGroupCollapse(int i)
			{
				if(i==group_pos)
				{
					expandableListView.findViewWithTag("Group_" + i).findViewById(R.id.ARROW_UP).setVisibility(View.GONE);
					expandableListView.findViewWithTag("Group_" + i).findViewById(R.id.ARROW_DOWN).setVisibility(View.VISIBLE);
				}
			}
		});
	}

	@Override
	public void onBackPressed()
	{
		DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
		if (drawer.isDrawerOpen(GravityCompat.START))
		{
			drawer.closeDrawer(GravityCompat.START);
		} else
		{
			super.onBackPressed();
		}
	}

	@SuppressWarnings("StatementWithEmptyBody")
	@Override
	public boolean onNavigationItemSelected(MenuItem item)
	{
		// Handle navigation view item clicks here.
		Intent nav = Util.getNavIntent(item.getItemId(), this);

		if (nav != null)
		{
			startActivity(nav);
		} else if (item.getItemId() == R.id.nav_logout)
		{

		}
		DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
		drawer.closeDrawer(GravityCompat.START);

		return true;
	}

}
