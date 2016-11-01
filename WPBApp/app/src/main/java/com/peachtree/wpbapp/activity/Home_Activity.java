package com.peachtree.wpbapp.Activity;

import android.app.Activity;
import android.app.DialogFragment;
import android.app.Fragment;
import android.app.FragmentTransaction;
import android.content.Context;
import android.os.Bundle;
import android.support.annotation.NonNull;
import android.support.design.widget.NavigationView;
import android.app.FragmentManager;
import android.support.v4.view.GravityCompat;
import android.support.v4.widget.DrawerLayout;
import android.support.v7.app.ActionBarDrawerToggle;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.view.MenuItem;
import android.view.View;
import android.view.inputmethod.InputMethod;
import android.view.inputmethod.InputMethodManager;

import com.peachtree.wpbapp.Activity.About_Fragment;
import com.peachtree.wpbapp.Activity.Event_Calendar_Fragment;
import com.peachtree.wpbapp.Activity.Event_Map_Fragment;
import com.peachtree.wpbapp.Activity.List_Fragment;
import com.peachtree.wpbapp.R;

/**
 * Created by Tyron on 10/18/2016.
 */
public class Home_Activity extends AppCompatActivity
		implements NavigationView.OnNavigationItemSelectedListener
		{
			private int stackNum = 0;
			private FragmentManager fragmentManager;
			private FragmentTransaction transaction;

			@Override
			protected void onCreate(Bundle savedInstanceState){

				super.onCreate(savedInstanceState);
				setContentView(R.layout.home_activity);

				fragmentManager = getFragmentManager();

				Toolbar toolbar = (Toolbar) findViewById(R.id.toolbar);
				setSupportActionBar(toolbar);

				final Context ctx = this;

				DrawerLayout drawer = (DrawerLayout)findViewById(R.id.drawer_layout);
				ActionBarDrawerToggle toggle = new ActionBarDrawerToggle(this, drawer, toolbar,
					R.string.navigation_drawer_open, R.string.navigation_drawer_close){

					@Override
					public void onDrawerOpened(View drawerView){
						super.onDrawerOpened(drawerView);
						InputMethodManager imm = (InputMethodManager)ctx.getSystemService(Activity.INPUT_METHOD_SERVICE);
						imm.hideSoftInputFromWindow(getCurrentFocus().getWindowToken(),0);
					}
				};
				drawer.setDrawerListener(toggle);
				toggle.syncState();

				NavigationView navigationView = (NavigationView) findViewById(R.id.nav_view);
				navigationView.setNavigationItemSelectedListener(this);

				if(fragmentManager.findFragmentByTag("embed") == null){
					switchFragment(R.id.nav_event_list);
				}
			}


			@Override
			public boolean onNavigationItemSelected(@NonNull MenuItem item)
			{
				switchFragment(item.getItemId());
				DrawerLayout drawerLayout = (DrawerLayout)findViewById(R.id.drawer_layout);
				drawerLayout.closeDrawer(GravityCompat.START);
				return true;
			}

			public void switchFragment(int id){

				DialogFragment fragment;
				stackNum++;
				Fragment prev;
				transaction = fragmentManager.beginTransaction();
				prev = fragmentManager.findFragmentByTag("embed");
				if(prev!=null){
					transaction.remove(prev);
				}

				switch (id){
					case R.id.nav_about:
						fragment = About_Fragment.init(stackNum);
						transaction.add(R.id.content, fragment, "embed");
						transaction.commit();
						break;
					case R.id.nav_clinics:
						fragment = List_Fragment.init(stackNum, List_Fragment.CLINIC);
						transaction.add(R.id.content, fragment, "embed");
						transaction.commit();
						break;
					case R.id.nav_event_calender:
						fragment = Event_Calendar_Fragment.init(stackNum);
						transaction.add(R.id.content ,fragment, "embed");
						transaction.commit();
						break;
					case R.id.nav_event_list:
						fragment = List_Fragment.init(stackNum, List_Fragment.EVENT);
						transaction.add(R.id.content, fragment, "embed");
						transaction.commit();
						break;
					case R.id.nav_event_map:
						fragment = Event_Map_Fragment.init(stackNum);
						transaction.add(R.id.content,fragment,"embed");
						transaction.commit();
						break;
				}
			}
		}
