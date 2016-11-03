package com.peachtree.wpbapp.Activity;

import android.Manifest;
import android.app.Activity;
import android.app.DialogFragment;
import android.app.Fragment;
import android.app.FragmentTransaction;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.pm.PackageManager;
import android.os.Bundle;
import android.support.annotation.NonNull;
import android.support.design.widget.NavigationView;
import android.app.FragmentManager;
import android.support.v4.app.ActivityCompat;
import android.support.v4.content.ContextCompat;
import android.support.v4.view.GravityCompat;
import android.support.v4.widget.DrawerLayout;
import android.support.v7.app.ActionBarDrawerToggle;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.view.inputmethod.InputMethodManager;
import android.widget.Toast;

import com.loopj.android.http.JsonHttpResponseHandler;
import com.peachtree.wpbapp.Core.Clinics;
import com.peachtree.wpbapp.Core.Events;
import com.peachtree.wpbapp.Entities.Clinic;
import com.peachtree.wpbapp.Entities.Event;
import com.peachtree.wpbapp.R;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.text.ParseException;
import java.util.ArrayList;

import cz.msebera.android.httpclient.Header;

public class Home_Activity extends AppCompatActivity implements NavigationView.OnNavigationItemSelectedListener {
	private int stackNum = 0;
	private FragmentManager fragmentManager;
	private FragmentTransaction transaction;

	// these events will be passed to future fragments/activities
	private ArrayList<Event> ALL_EVENTS;
	private ArrayList<Clinic> ALL_CLINICS;

	// API helper for events and clinic data
	private Events EVENTS_HELPER;
	private Clinics CLINICS_HELPER;

	private final static int PERMISSIONS_INTERNET_VALUE = 1;

	private ActionBarDrawerToggle ACTION_BAR_TOGGLE;

	// method to set our events and clinics
	// this is because we are using async tasks, and passing a reference to our lists
	// in closures.
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

		// set up our helpers
		EVENTS_HELPER = new Events(this.getApplicationContext());
		CLINICS_HELPER = new Clinics(this.getApplicationContext());

		fragmentManager = getFragmentManager();

		Toolbar toolbar = (Toolbar) findViewById(R.id.toolbar);
		setSupportActionBar(toolbar);

		final Context ctx = this;

		final DrawerLayout drawer = (DrawerLayout)findViewById(R.id.drawer_layout);

		// setup our action bar toggle
		setActionBarToggle(new ActionBarDrawerToggle(this, drawer, toolbar,
				R.string.navigation_drawer_open, R.string.navigation_drawer_close){

			@Override
			public void onDrawerOpened(View drawerView){
				super.onDrawerOpened(drawerView);
				InputMethodManager imm = (InputMethodManager)ctx.getSystemService(Activity.INPUT_METHOD_SERVICE);
				imm.hideSoftInputFromWindow(getCurrentFocus().getWindowToken(),0);
			}
		});

		drawer.setDrawerListener(ACTION_BAR_TOGGLE);
		ACTION_BAR_TOGGLE.syncState();

		NavigationView navigationView = (NavigationView) findViewById(R.id.nav_view);
		navigationView.setNavigationItemSelectedListener(this);

		if(fragmentManager.findFragmentByTag("embed") == null){
			switchFragment(R.id.nav_event_list);
		}

		// before we do anything, we need to make sure that we have permissions
		int permissionCheck = ContextCompat.checkSelfPermission(this, Manifest.permission.INTERNET);

		if(permissionCheck == PackageManager.PERMISSION_DENIED) {
			// check if we need to explain why we need permissions
			if (ActivityCompat.shouldShowRequestPermissionRationale(this, Manifest.permission.INTERNET)) {
				// we should show this asynchronously
				Toast.makeText(this,
						"We need access to the internet to load clinic and event data.",
						Toast.LENGTH_LONG).show();

			}
			// don't need to show an explanation, ask for permission
			else {
				ActivityCompat.requestPermissions(this,
						new String[]{Manifest.permission.INTERNET},
						PERMISSIONS_INTERNET_VALUE);

			}
		} else {
			// we have permissions, continue
			setUpApplication(this, ACTION_BAR_TOGGLE);
		}
	}

	@Override
	public void onRequestPermissionsResult(int requestCode, String permissions[], int[] grantResults) {
		switch (requestCode) {
			case PERMISSIONS_INTERNET_VALUE: {
				// results array is 0 if the request dialog is closed
				if (grantResults.length > 0	&& grantResults[0] == PackageManager.PERMISSION_GRANTED) {
					// we have  permission!
					setUpApplication(getApplicationContext(), ACTION_BAR_TOGGLE);
				} else {
					// we were denied / cancelled permission
					Toast.makeText(getApplicationContext(),
							"We need internet access to load data.", Toast.LENGTH_LONG).show();
				}
				return;
			}
		}
	}

	private void setUpApplication(final Context ctx, final ActionBarDrawerToggle toggle) {
		final ProgressDialog progress = new ProgressDialog(this);

		progress.setTitle("Please wait");
		progress.setMessage("We are loading the events and clinics data.");

		// before we want sync the state, we want to do a few network requests
		// get all events
		EVENTS_HELPER.GetAllEvents(new JsonHttpResponseHandler() {
			@Override
			public void onStart() {
				progress.show();
			}

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
					// see if we have an error
					if(o.has("error")) {
						// get the message
						String msg = o.getString("message");

						// show the message
						Toast.makeText(getApplicationContext(), msg, Toast.LENGTH_SHORT).show();
					}
				} catch (JSONException e) {
					e.printStackTrace();
				}
			}

			// network request failed
			@Override
			public void onFailure(int statusCode, Header[] headers, Throwable throwable, JSONObject response) {
				// show to the user
				Toast.makeText(ctx, "There was an error connecting to the server, please try again in a few moments.",
						Toast.LENGTH_SHORT).show();
			}

			// once the request is done, lets do some cleanup
			@Override
			public void onFinish() {
				progress.hide();
			}
		});

		// get all clinics async task
		CLINICS_HELPER.GetAllClinics(new JsonHttpResponseHandler() {
			@Override
			public void onSuccess(int statusCode, Header[] headers, JSONArray a) {
				try {
					// try and set the clinics to the json response
					setClinics(Clinic.ClinicsFromJsonArray(a));
				}
				// any exception here a user cannot really fix
				catch (Exception e) {
					Toast.makeText(getApplicationContext(),
							"Oops! It looks like there was a problem with getting the clinics. Please contact one of the developers!",
							Toast.LENGTH_SHORT);
				}
			}

			// even though it "Succeeded" the response may have an error
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

			// total failure. i.e no connection
			@Override
			public void onFailure(int statusCode, Header[] headers, Throwable throwable, JSONObject response) {
				// show to the user
				Toast.makeText(ctx, "There was an error connecting to the server, please try again in a few moments.", Toast.LENGTH_SHORT).show();
			}
		});
	}

	@Override
	public boolean onCreateOptionsMenu(Menu menu) {
		getMenuInflater().inflate(R.menu.refresh, menu);
		return true;
	}

	@Override
	public boolean onOptionsItemSelected(MenuItem item) {
		int id = item.getItemId();

		if (id == R.id.reload) {
			setUpApplication(this, ACTION_BAR_TOGGLE);
		}

		return super.onOptionsItemSelected(item);
	}

	@Override
	public boolean onNavigationItemSelected(@NonNull MenuItem item)
	{
		switchFragment(item.getItemId());
		DrawerLayout drawerLayout = (DrawerLayout)findViewById(R.id.drawer_layout);
		drawerLayout.closeDrawer(GravityCompat.START);
		return true;
	}

	private void setActionBarToggle(ActionBarDrawerToggle toggle) {
		ACTION_BAR_TOGGLE = toggle;
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
			case R.id.nav_logout:
				finish();
				break;
		}
	}

	public void loadCenteredMap(Event_Map_Fragment map){
		Fragment prev = fragmentManager.findFragmentByTag("embed");
			transaction = getFragmentManager().beginTransaction();
		if(prev!=null){
			transaction.remove(prev);
		}
		transaction.add(R.id.content, map, "embed");
		transaction.commit();
	}
}