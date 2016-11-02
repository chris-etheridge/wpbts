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
import android.util.Log;
import android.view.MenuItem;
import android.view.View;
import android.view.inputmethod.InputMethod;
import android.view.inputmethod.InputMethodManager;
import android.widget.Toast;

import com.loopj.android.http.JsonHttpResponseHandler;
import com.peachtree.wpbapp.Activity.About_Fragment;
import com.peachtree.wpbapp.Activity.Event_Calendar_Fragment;
import com.peachtree.wpbapp.Activity.Event_Map_Fragment;
import com.peachtree.wpbapp.Activity.List_Fragment;
import com.peachtree.wpbapp.Core.Clinics;
import com.peachtree.wpbapp.Core.Events;
import com.peachtree.wpbapp.Core.Networking;
import com.peachtree.wpbapp.Entities.Clinic;
import com.peachtree.wpbapp.Entities.Event;
import com.peachtree.wpbapp.R;
import com.peachtree.wpbapp.layout_Handlers.List_Adapter;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.text.ParseException;
import java.util.ArrayList;

import cz.msebera.android.httpclient.Header;

import static com.peachtree.wpbapp.Entities.Event.EventsFromJsonArray;

/**
 * Created by Tyron on 10/18/2016.
 */
public class Home_Activity extends AppCompatActivity implements NavigationView.OnNavigationItemSelectedListener {
	private int stackNum = 0;
	private FragmentManager fragmentManager;
	private FragmentTransaction transaction;

	// these events will be passed to future fragments/activities
	private ArrayList<Event> ALL_EVENTS;
	private ArrayList<Clinic> ALL_CLINICS;

	private Events EVENTS_HELPER;
	private Clinics CLINICS_HELPER;

	private void setEvents(ArrayList<Event> es) {
		ALL_EVENTS = es;
	}

	private void setClinics(ArrayList<Clinic> cs) {
		ALL_CLINICS = cs;
	}

	@Override
	protected void onCreate(Bundle savedInstanceState) {

		super.onCreate(savedInstanceState);
		setContentView(R.layout.home_activity);

		EVENTS_HELPER = new Events(this.getApplicationContext());
		CLINICS_HELPER = new Clinics(this.getApplicationContext());

		fragmentManager = getFragmentManager();

		Toolbar toolbar = (Toolbar) findViewById(R.id.toolbar);
		setSupportActionBar(toolbar);

		final Context ctx = this;

		final DrawerLayout drawer = (DrawerLayout)findViewById(R.id.drawer_layout);
		final ActionBarDrawerToggle toggle = new ActionBarDrawerToggle(this, drawer, toolbar,
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

		// before we want sync the state, we want to do a few network requests
		// get all events
		EVENTS_HELPER.GetAllEvents(new JsonHttpResponseHandler() {
			@Override
			public void onSuccess(int statusCode, Header[] headers, JSONArray a) {
				try {
					setEvents(Event.EventsFromJsonArray(a));

					toggle.syncState();

					switchFragment(R.id.nav_event_list);
				} catch (JSONException e) {

				} catch (ParseException e) {
					e.printStackTrace();
				}
			}

			@Override
			public void onSuccess(int statusCode, Header[] headers, JSONObject o) {
				try {
					// we have an error
					if(o.getString("error") != null || o.getString("error") != "") {
						// parse the error
						int code = o.getInt("code");

						// get the message
						String msg = o.getString("message");
                    }
				} catch (JSONException e) {
					e.printStackTrace();
				}
			}

			@Override
			public void onFailure(int statusCode, Header[] headers, Throwable throwable, JSONObject response) {
				// show to the user
				Toast.makeText(ctx, "There was an error connecting to the server, please try again in a few moments.", Toast.LENGTH_SHORT).show();
			}
		});

		// get all clinics
		CLINICS_HELPER.GetAllClinics(new JsonHttpResponseHandler() {
			@Override
			public void onSuccess(int statusCode, Header[] headers, JSONArray a) {
				try {
					setClinics(Clinic.ClinicsFromJsonArray(a));
				} catch (JSONException e) {

				} catch (ParseException e) {
					e.printStackTrace();
				}
			}

			@Override
			public void onSuccess(int statusCode, Header[] headers, JSONObject o) {
				try {
					// we have an error
					if(o.getString("error") != null || o.getString("error") != "") {
						// parse the error
						int code = o.getInt("code");

						// get the message
						String msg = o.getString("message");
					}
				} catch (JSONException e) {
					e.printStackTrace();
				}
			}

			@Override
			public void onFailure(int statusCode, Header[] headers, Throwable throwable, JSONObject response) {
				// show to the user
				Toast.makeText(ctx, "There was an error connecting to the server, please try again in a few moments.", Toast.LENGTH_SHORT).show();
			}
		});
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

				((List_Fragment) fragment).setItems(ALL_CLINICS);

				transaction.add(R.id.content, fragment, "embed");
				transaction.commit();
				break;
			case R.id.nav_event_calender:
				fragment = Event_Calendar_Fragment.init(stackNum);

				((Event_Calendar_Fragment) fragment).setItems(ALL_EVENTS);

				transaction.add(R.id.content , fragment, "embed");
				transaction.commit();
				break;
			case R.id.nav_event_list:
				fragment = List_Fragment.init(stackNum, List_Fragment.EVENT);

				((List_Fragment) fragment).setItems(ALL_EVENTS);

				transaction.add(R.id.content, fragment, "embed");
				transaction.commit();
				break;
			case R.id.nav_event_map:
				fragment = Event_Map_Fragment.init(stackNum);

				((Event_Map_Fragment) fragment).setEvents(ALL_EVENTS);

				transaction.add(R.id.content,fragment,"embed");
				transaction.commit();
				break;
		}
	}
}
