<h2>
    {{ $job->title }}
</h2>

<p>
    Congrats! Your job is live on our website now.
</p>

<p>
    <a href="{{ url('/jobs/' . $job->id) }}">View your job list</a>
</p>