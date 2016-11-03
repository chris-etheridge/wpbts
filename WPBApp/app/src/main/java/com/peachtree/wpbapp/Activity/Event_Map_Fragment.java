package com.peachtree.wpbapp.Activity;

import android.Manifest;
import android.app.Activity;
import android.app.DialogFragment;
import android.app.FragmentTransaction;
import android.content.Context;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.location.Criteria;
import android.location.Location;
import android.location.LocationListener;
import android.location.LocationManager;
import android.net.Uri;
import android.os.Bundle;
import android.support.v4.app.FragmentActivity;
import android.support.v4.content.ContextCompat;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;
import android.widget.Toast;

import com.google.android.gms.maps.CameraUpdateFactory;
import com.google.android.gms.maps.GoogleMap;
import com.google.android.gms.maps.OnMapReadyCallback;
import com.google.android.gms.maps.MapFragment;
import com.google.android.gms.maps.model.BitmapDescriptorFactory;
import com.google.android.gms.maps.model.LatLng;
import com.google.android.gms.maps.model.Marker;
import com.google.android.gms.maps.model.MarkerOptions;
import com.peachtree.wpbapp.Entities.Event;
import com.peachtree.wpbapp.R;

import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Iterator;
import java.util.Locale;

public class Event_Map_Fragment extends DialogFragment implements OnMapReadyCallback, GoogleMap.OnMarkerClickListener, LocationListener
{

	private Activity parent;
	private int stackNum, index = -1, center_index = -1;
	private MapFragment mapFragment;
	private GoogleMap mMap;
	private View mView;
	private LocationManager location;
	private Criteria criteria;

	@Override
	public void onLocationChanged(Location location) {
		if(location != null) {
			mMap.moveCamera(CameraUpdateFactory.newLatLngZoom(new LatLng(location.getLatitude(), location.getLongitude()), 10));
			mMap.addMarker(new MarkerOptions().position(new LatLng(location.getLatitude(), location.getLongitude())).draggable(false)
					.icon(BitmapDescriptorFactory.fromResource(R.drawable.user_icon)));
		}
	}

	@Override
	public void onStatusChanged(String provider, int status, Bundle extras) {

	}

	@Override
	public void onProviderEnabled(String provider) {

	}

	@Override
	public void onProviderDisabled(String provider) {

	}

	@Override
	public boolean onMarkerClick(Marker marker) {

		index = (int)marker.getTag();

		((TextView)mView.findViewById(R.id.TXT_description)).setText(generateDescription(events.get(index)));

		return true;
	}

	public void preloadData(){
		((TextView)mView.findViewById(R.id.TXT_description)).setText(generateDescription(events.get(center_index)));
	}

	private ArrayList<Event> events;

	@Override
	public void onMapReady(GoogleMap googleMap)
	{
		mMap = googleMap;
		if(ContextCompat.checkSelfPermission(parent, Manifest.permission.ACCESS_FINE_LOCATION) == PackageManager.PERMISSION_GRANTED) {
			mMap.setMyLocationEnabled(true);
		}else{

		}
		mMap.getUiSettings().setMyLocationButtonEnabled(true);
		mMap.getUiSettings().setZoomControlsEnabled(true);
		if(center_index != -1){
			mMap.moveCamera(CameraUpdateFactory.newLatLngZoom(new LatLng(events.get(center_index).getLat(), events.get(center_index).getLng()), 10));
		}
		loadEventsToMap();
	}

	public static Event_Map_Fragment init(int stackNum){
		Event_Map_Fragment fragment = new Event_Map_Fragment();

		Bundle args = new Bundle();
		args.putInt("stackNum", stackNum);
		fragment.setArguments(args);

		return fragment;
	}

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);

		parent = getActivity();
		stackNum = getArguments().getInt("stackNum");

		mapFragment = new MapFragment();
		location = (LocationManager)(parent.getSystemService(Context.LOCATION_SERVICE));
    }

	@Override
	public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState)
	{
		super.onCreateView(inflater, container, savedInstanceState);
		final View view = inflater.inflate(R.layout.event_map_layout, container, false);

		final FragmentTransaction transaction = getChildFragmentManager().beginTransaction();
		transaction.add(R.id.map_layout, mapFragment, "map").commit();
		mapFragment.getMapAsync(this);

		view.findViewById(R.id.BTN_directions).setOnClickListener(new View.OnClickListener() {
			@Override
			public void onClick(View v) {
				String uri = String.format(Locale.ENGLISH, "geo:%f,%f", events.get(index).getLat(), events.get(index).getLng());
				Intent intent = new Intent(Intent.ACTION_VIEW, Uri.parse(uri));
				parent.startActivity(intent);
			}
		});

		view.findViewById(R.id.BTN_view).setOnClickListener(new View.OnClickListener()
		{
			@Override
			public void onClick(View v)
			{
				if(index != -1 && events.get(index) != null){
					Event_Info_Fragment info = Event_Info_Fragment.init(events.get(index).getId());
					info.loadEvents(events);
					FragmentTransaction mTransaction = parent.getFragmentManager().beginTransaction();
					mTransaction.add(info, "dialog");
					mTransaction.commit();
				}
			}
		});

		mView = view;
		return view;
	}

	public void setEvents(ArrayList<Event> e){
		events = e;
	}

	private void loadEventsToMap(){
		if(events != null) {
			for (int i = 0; i < events.size(); i++) {
				Event e = events.get(i);
				LatLng co_ord = new LatLng(e.getLat(), e.getLng());
				MarkerOptions mOpt = new MarkerOptions().position(co_ord).title(e.getTitle()).draggable(false);
				Marker marker = mMap.addMarker(mOpt);

				marker.setTag(i);
			}
		}
	}

	private String generateDescription(Event event){
		SimpleDateFormat dayFormat = new SimpleDateFormat("EEEE dd");
		String output = String.format("%s\n%s\n%s\n%s", event.getTitle(), event.getAddress(),
				dayFormat.format(event.getDate()));
		return output;
	}

	@Override
	public void onResume(){
		super.onResume();
		criteria = new Criteria();
		criteria.setAccuracy(Criteria.ACCURACY_FINE);
		criteria.setPowerRequirement(Criteria.NO_REQUIREMENT);

		if(ContextCompat.checkSelfPermission(parent, Manifest.permission.ACCESS_FINE_LOCATION) == PackageManager.PERMISSION_GRANTED){
			location.requestSingleUpdate(criteria, this, null);
		}
		else {
			Toast.makeText(parent, "Please allow location in app permissions.", Toast.LENGTH_SHORT).show();
		}
	}

	public void centerOn(int index){
		center_index = index;
		preloadData();
	}
}
